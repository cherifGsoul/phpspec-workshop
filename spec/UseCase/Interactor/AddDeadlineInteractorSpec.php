<?php

namespace spec\Cherif\Todo\UseCase\Interactor;

use Cherif\Todo\Entity\Todo;
use Cherif\Todo\Entity\TodoList;
use Cherif\Todo\UseCase\Data\AddDeadlineInput;
use Cherif\Todo\UseCase\Data\AddDeadlineOutput;
use Cherif\Todo\UseCase\Interactor\AddDeadlineInteractor;
use DateTimeImmutable;
use DateTimeZone;
use DomainException;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;

class AddDeadlineInteractorSpec extends ObjectBehavior
{
    function it_adds_a_deadline(TodoList $todoList, Todo $todo)
    {
        $this->beConstructedWith($todoList);
        $deadlineStr = date("d/m/Y", strtotime("+1 month"));
        $input = new AddDeadlineInput('Learn TDD', 'cherif', $deadlineStr);
        $deadline = DateTimeImmutable::createFromFormat(
            'd/m/Y', 
            $input->getDate(),
            new DateTimeZone('Africa/Algiers')
        );
        $todo->getName()->willReturn($input->getName());
        $todo->getOwner()->willReturn($input->getOwner());
        $todo->getDeadline()->willReturn($deadline);
        $todoList->getForName($input->getName())->willReturn($todo);
        $todo->addDeadline($deadline, $input->getOwner())->shouldBeCalled();
        $this->handle($input)->shouldReturnAnInstanceOf(AddDeadlineOutput::class);
        $todoList->save($todo)->shouldHaveBeenCalled();
    }

    function it_throws_when_deadline_added_by_another_owner(TodoList $todoList, Todo $todo)
    {
        $this->beConstructedWith($todoList);
        $deadlineStr = date("d/m/Y", strtotime("+1 month"));
        $input = new AddDeadlineInput('Learn TDD', 'ryadh', $deadlineStr);
        $deadline = DateTimeImmutable::createFromFormat(
            'd/m/Y', 
            $input->getDate(),
            new DateTimeZone('Africa/Algiers')
        );
        $todo->getName()->willReturn($input->getName());
        $todo->getOwner()->willReturn('cherif');
        $todo->getDeadline()->willReturn($deadline);
        $todoList->getForName($input->getName())->willReturn($todo);
        $todo->addDeadline($deadline, $input->getOwner())->willThrow(DomainException::class);
        $this->shouldThrow(InvalidArgumentException::class)->during('handle', [$input]);
    }

    function it_throws_when_the_deadline_is_not_in_the_future(TodoList $todoList, Todo $todo)
    {
        $this->beConstructedWith($todoList);
        $deadlineStr = date("d/m/Y");
        $input = new AddDeadlineInput('Learn TDD', 'ryadh', $deadlineStr);
        $deadline = DateTimeImmutable::createFromFormat(
            'd/m/Y', 
            $input->getDate(),
            new DateTimeZone('Africa/Algiers')
        );
        $todo->getName()->willReturn($input->getName());
        $todo->getOwner()->willReturn('cherif');
        $todo->getDeadline()->willReturn($deadline);
        $todoList->getForName($input->getName())->willReturn($todo);
        $todo->addDeadline($deadline, $input->getOwner())->willThrow(DomainException::class);
        $this->shouldThrow(InvalidArgumentException::class)->during('handle', [$input]);
    }
}
