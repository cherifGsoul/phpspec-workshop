<?php

namespace spec\Cherif\Todolist\Usecase;

use Cherif\Todolist\Usecase\AddTodoInteractor;
use Cherif\Todolist\Usecase\Data\AddTodoInput;
use Cherif\Todolist\Usecase\Data\AddTodoOutput;
use Cherif\Todolist\Domain\Model\TodoList;
use Cherif\Todolist\Domain\Model\Todo;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AddTodoInteractorSpec extends ObjectBehavior
{
    function let(TodoList $todoList)
    {
        $this->beConstructedWith($todoList);
    }

    function it_adds_a_todo(TodoList $todoList)
    {
        $input = new AddTodoInput('Learn PHPSpec', 'mahi');
        // Execution
        $this->__invoke($input);
        // Spy test double
        $todoList->save(Argument::type(Todo::class))->shouldHaveBeenCalled();
    }
}
