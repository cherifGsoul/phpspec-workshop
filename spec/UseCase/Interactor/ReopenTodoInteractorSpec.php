<?php

namespace spec\Cherif\Todo\UseCase\Interactor;

use Cherif\Todo\Entity\Todo;
use Cherif\Todo\Entity\TodoList;
use Cherif\Todo\UseCase\Data\ReopenTodoInput;
use Cherif\Todo\UseCase\Data\ReopenTodoOutput;
use Cherif\Todo\UseCase\Interactor\ReopenTodoInteractor;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;

class ReopenTodoInteractorSpec extends ObjectBehavior
{
    function let(TodoList $todoList)
    {
        $this->beConstructedWith($todoList);
    }

    function it_reopen_a_marked_done_todo(TodoList $todoList)
    {
        $input = new ReopenTodoInput('Learn TDD', 'cherif');
        $todo = Todo::add($input->getName(), $input->getOwner());
        $todo->markAsDone($input->getOwner());
        $todoList->getForName($input->getName())->willReturn($todo);
        $this->handle($input)->shouldReturnAnInstanceOf(ReopenTodoOutput::class);
        $todoList->save($todo)->shouldHaveBeenCalled();
    }

    function it_throws_when_todo_owner_is_not_valid(TodoList $todoList)
    {
        $todo = Todo::add('Learn OOP', 'cherif');
        $todo->markAsDone('cherif');
        $todoList->getForName('Learn OOP')->willReturn($todo);
        $input = new ReopenTodoInput('Learn OOP', 'ryadh');
        $this->shouldThrow(InvalidArgumentException::class)->during('handle', [$input]);
    }

    function it_can_be_reopened_only_when_is_done(TodoList $todoList)
    {
        $todo = Todo::add('Learn OOP', 'cherif');
        $todoList->getForName('Learn OOP')->willReturn($todo);
        $input = new ReopenTodoInput('Learn OOP', 'cherif');
        $this->shouldThrow(InvalidArgumentException::class)->during('handle', [$input]);
    }
}
