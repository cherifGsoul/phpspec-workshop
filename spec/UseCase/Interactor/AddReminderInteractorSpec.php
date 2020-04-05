<?php

namespace spec\Cherif\Todo\UseCase\Interactor;

use Cherif\Todo\Entity\Todo;
use Cherif\Todo\Entity\TodoList;
use Cherif\Todo\UseCase\Data\AddReminderInput;
use Cherif\Todo\UseCase\Data\AddReminderOutput;
use Cherif\Todo\UseCase\Interactor\AddReminderInteractor;
use DateInterval;
use DateTimeImmutable;
use DateTimeZone;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AddReminderInteractorSpec extends ObjectBehavior
{
    public function let(TodoList $todoList)
    {
        $this->beConstructedWith($todoList);
    }

    function it_adds_a_reminder(TodoList $todoList)
    {
        $this->beConstructedWith($todoList);
        
        //Today's date
        $today = new DateTimeImmutable();
        // add one month for the deadline
        $deadline = $today->add(new DateInterval('P1M'));
        // Substract 2 days for the reminder
        $reminder = $deadline->sub(new DateInterval('P2D'));

        $input = new AddReminderInput('Learn TDD', 'cherif', $reminder->format('d/m/Y'));
        
        $todo = Todo::add($input->getName(), $input->getOwner());
        $todo->addDeadline($deadline, $input->getOwner());

        $todoList->getForName($input->getName())->willReturn($todo);
        
        $this->handle($input)->shouldReturnAnInstanceOf(AddReminderOutput::class);
        $todoList->save(Argument::type(Todo::class))->shouldHaveBeenCalled();
    }

    function it_throws_when_deadline_added_by_another_owner(TodoList $todoList)
    {
        $this->beConstructedWith($todoList);

         //Today's date
         $today = new DateTimeImmutable();
         // add one month for the deadline
         $deadline = $today->add(new DateInterval('P1M'));
         // Substract 2 days for the reminder
         $reminder = $deadline->sub(new DateInterval('P2D'));

        $todo = Todo::add('Learn TDD', 'cherif');
        $todo->addDeadline($deadline, 'cherif');
        $todo->addReminder($reminder, 'cherif');
        $input = new AddReminderInput('Learn TDD', 'ryadh', $reminder->format('d/m/Y'));
        $todoList->getForName($input->getName())->willReturn($todo);
        $this->shouldThrow(InvalidArgumentException::class)->during('handle', [$input]);
    }

    function it_throws_when_the_deadline_is_not_in_the_future(TodoList $todoList)
    {
        $this->beConstructedWith($todoList);
        $reminder = date("d/m/Y");
        $todo = Todo::add('Learn TDD', 'cherif');
        $input = new AddReminderInput('Learn TDD', 'cherif', $reminder);
        $todoList->getForName($input->getName())->willReturn($todo);
        $this->shouldThrow(InvalidArgumentException::class)->during('handle', [$input]);
    }

    function it_throws_when_reminder_added_without_a_deadline(TodoList $todoList)
    {
        $this->beConstructedWith($todoList);
         //Today's date
         $today = new DateTimeImmutable();
         // Substract 2 days for the reminder
         $reminder = $today->add(new DateInterval('P1M'));

        $input = new AddReminderInput('Learn TDD', 'cherif', $reminder->format('d/m/Y'));
        $todoList->getForName($input->getName())->willReturn(Todo::add($input->getName(), $input->getOwner()));
        $this->shouldThrow()->during('handle',[$input]);
    }
}
