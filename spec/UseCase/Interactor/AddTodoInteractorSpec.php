<?php

namespace spec\Cherif\Todolist\UseCase\Interactor;

use Cherif\Todolist\UseCase\Interactor\AddTodoInteractor;
use Cherif\Todolist\UseCase\Data\AddTodoInput;
use Cherif\Todolist\UseCase\Data\AddTodoOutput;
use Cherif\Todolist\Entity\TodoList;
use Cherif\Todolist\Entity\Todo;
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
