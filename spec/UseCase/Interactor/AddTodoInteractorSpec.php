<?php

namespace spec\Cherif\Todo\UseCase\Interactor;

use Cherif\Todo\UseCase\Interactor\AddTodoInteractor;
use Cherif\Todo\UseCase\Data\AddTodoInput;
use Cherif\Todo\Entity\Todo;
use Cherif\Todo\Entity\TodoList;
use Cherif\Todo\UseCase\Data\AddTodoOutput;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AddTodoInteractorSpec extends ObjectBehavior
{
    function it_adds_a_todo(TodoList $todoList)
    {
        $this->beConstructedWith($todoList);
        $input = new AddTodoInput('Learn PHPSPEC', 'cherif');
        $this->handle($input)->shouldReturnAnInstanceOf(AddTodoOutput::class);
        $todoList->save(Argument::type(Todo::class))->shouldHaveBeenCalled();
    }
}
