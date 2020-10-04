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
use DomainException;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AddReminderInteractorSpec extends ObjectBehavior
{
    public function let(TodoList $todoList)
    {
        $this->beConstructedWith($todoList);
    }

    function it_adds_a_reminder(TodoList $todoList, Todo $todo)
    {
        $this->beConstructedWith($todoList);
        //Today's date
        $today = DateTimeImmutable::createFromFormat('d/m/Y', date('d/m/Y'), new DateTimeZone('Africa/Algiers'));
        // add one month for the deadline
        $deadline = $today->add(new DateInterval('P1M'));
        // Substract 2 days for the reminder
        $reminder = $deadline->sub(new DateInterval('P2D'));
        $input = new AddReminderInput('Learn TDD', 'cherif', $reminder->format('d/m/Y'));
        $todoList->getForName($input->getName())->willReturn($todo);
        $todo->getName()->willReturn($input->getName());
        $todo->getOwner()->willReturn($input->getOwner());
        $todo->getReminder()->willReturn($reminder);
        $todo->addReminder($reminder, $input->getOwner())->shouldBeCalled();
        $this->handle($input)->shouldReturnAnInstanceOf(AddReminderOutput::class);
        $todoList->save($todo)->shouldHaveBeenCalled();
    }

    function it_throws_when_deadline_added_by_another_owner(TodoList $todoList, Todo $todo)
    {
        $this->beConstructedWith($todoList);
        //Today's date
        $today = DateTimeImmutable::createFromFormat('d/m/Y', date('d/m/Y'), new DateTimeZone('Africa/Algiers'));
        // add one month for the deadline
        $deadline = $today->add(new DateInterval('P1M'));
        // Substract 2 days for the reminder
        $reminder = $deadline->sub(new DateInterval('P2D'));
        $input = new AddReminderInput('Learn TDD', 'ryadh', $reminder->format('d/m/Y'));
        $todoList->getForName($input->getName())->willReturn($todo);
        $todo->getName()->willReturn($input->getName());
        $todo->getOwner()->willReturn($input->getOwner());
        $todo->getReminder()->willReturn($reminder);
        $todo->addReminder($reminder, $input->getOwner())->willThrow(DomainException::class);
        $this->shouldThrow(InvalidArgumentException::class)->during('handle', [$input]);
    }

    function it_throws_when_the_reminder_is_not_in_the_future(TodoList $todoList, Todo $todo)
    {
        $this->beConstructedWith($todoList);
        $reminder = DateTimeImmutable::createFromFormat('d/m/Y', date("d/m/Y"), new DateTimeZone('Africa/Algiers'));
        $input = new AddReminderInput('Learn TDD', 'cherif', $reminder->format('d/m/Y'));
        $todoList->getForName($input->getName())->willReturn($todo);
        $todo->addReminder($reminder, $input->getOwner())->willThrow(DomainException::class);
        $this->shouldThrow(InvalidArgumentException::class)->during('handle', [$input]);
    }

    function it_throws_when_reminder_added_without_a_deadline(TodoList $todoList, Todo $todo)
    {
        $this->beConstructedWith($todoList);
         //Today's date
        $today = DateTimeImmutable::createFromFormat('d/m/Y', date('d/m/Y'), new DateTimeZone('Africa/Algiers'));
        // Substract 2 days for the reminder
        $reminder = $today->add(new DateInterval('P1M'));

        $input = new AddReminderInput('Learn TDD', 'cherif', $reminder->format('d/m/Y'));
        $todoList->getForName($input->getName())->willReturn(Todo::add($input->getName(), $input->getOwner()));
        $todo->getName()->willReturn($input->getName());
        $todo->getOwner()->willReturn($input->getOwner());
        $todo->getReminder()->willReturn($reminder);
        $todo->hasDeadline()->willReturn(false);
        $todo->addReminder($reminder, $input->getOwner())->willThrow(DomainException::class);
        $this->shouldThrow(InvalidArgumentException::class)->during('handle', [$input]);
    }
}
