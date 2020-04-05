<?php

namespace spec\Cherif\Todo\UseCase\Interactor;

use Cherif\Todo\Entity\Todo;
use Cherif\Todo\Entity\TodoList;
use Cherif\Todo\UseCase\Data\AddDeadlineInput;
use Cherif\Todo\UseCase\Data\AddDeadlineOutput;
use Cherif\Todo\UseCase\Interactor\AddDeadlineInteractor;
use DateTimeImmutable;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AddDeadlineInteractorSpec extends ObjectBehavior
{
    function it_adds_a_deadline(TodoList $todoList)
    {
        $this->beConstructedWith($todoList);
        $todayTimestamp = strtotime(date('d/m/Y'));
        $deadlineStr = date("d/m/Y", strtotime("+1 month", $todayTimestamp));
        $input = new AddDeadlineInput('Learn TDD', 'cherif', $deadlineStr);
        $todoList->getForName($input->getName())->willReturn(Todo::add($input->getName(), $input->getOwner()));
        $this->handle($input)->shouldReturnAnInstanceOf(AddDeadlineOutput::class);
        $todoList->save(Argument::type(Todo::class))->shouldHaveBeenCalled();
    }

    function it_throws_when_deadline_added_by_another_owner(TodoList $todoList)
    {
        $this->beConstructedWith($todoList);
        $todayTimestamp = strtotime(date('d/m/Y'));
        $deadlineStr = date("d/m/Y", strtotime("+1 month", $todayTimestamp));
        $todo = Todo::add('Learn TDD', 'cherif');
        $input = new AddDeadlineInput('Learn TDD', 'ryadh', $deadlineStr);
        $todoList->getForName($input->getName())->willReturn($todo);
        $this->shouldThrow(InvalidArgumentException::class)->during('handle', [$input]);
    }

    function it_throws_when_the_deadline_is_not_in_the_future(TodoList $todoList)
    {
        $this->beConstructedWith($todoList);
        $deadlineStr = date("d/m/Y");
        $todo = Todo::add('Learn TDD', 'cherif');
        $input = new AddDeadlineInput('Learn TDD', 'cherif', $deadlineStr);
        $todoList->getForName($input->getName())->willReturn($todo);
        $this->shouldThrow(InvalidArgumentException::class)->during('handle', [$input]);
    }
}
