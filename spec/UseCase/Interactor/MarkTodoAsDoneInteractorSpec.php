<?php

namespace spec\Cherif\Todo\UseCase\Interactor;

use Cherif\Todo\Entity\Todo;
use Cherif\Todo\Entity\TodoList;
use Cherif\Todo\UseCase\Interactor\MarkTodoAsDoneInteractor;
use Cherif\Todo\UseCase\Data\MarkTodoAsDoneInput;
use Cherif\Todo\UseCase\Data\MarkTodoAsDoneOutput;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MarkTodoAsDoneInteractorSpec extends ObjectBehavior
{
    function let(TodoList $todoList)
    {
        $this->beConstructedWith($todoList);
    }
    function it_marks_todo_as_done(TodoList $todoList)
    {
        $todo = Todo::add('Learn OOP', 'cherif');
        $todoList->getForName('Learn OOP')->willReturn($todo);
        $input = new MarkTodoAsDoneInput('Learn OOP', 'cherif');
        $this->handle($input)->shouldReturnAnInstanceOf(MarkTodoAsDoneOutput::class);
        $todoList->save($todo)->shouldHaveBeenCalled();
    }

    function it_throws_when_todo_owner_is_not_valid(TodoList $todoList)
    {
        $todo = Todo::add('Learn OOP', 'cherif');
        $todoList->getForName('Learn OOP')->willReturn($todo);
        $input = new MarkTodoAsDoneInput('Learn OOP', 'ryadh');
        $this->shouldThrow(InvalidArgumentException::class)->during('handle', [$input]);
    }

    function it_can_only_be_marked_as_done_when_is_open(TodoList $todoList)
    {
        $todo = Todo::add('Learn OOP', 'cherif');
        $todo->markAsDone('cherif');
        $todoList->getForName('Learn OOP')->willReturn($todo);
        $input = new MarkTodoAsDoneInput('Learn OOP', 'cherif');
        $this->shouldThrow(InvalidArgumentException::class)->during('handle', [$input]);
    }
}
