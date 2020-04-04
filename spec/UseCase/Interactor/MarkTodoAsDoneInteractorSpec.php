<?php

namespace spec\Cherif\Todolist\UseCase\Interactor;

use Cherif\Todolist\Entity\Todo;
use Cherif\Todolist\Entity\TodoList;
use Cherif\Todolist\UseCase\Data\MarkTodoAsDoneInput;
use Cherif\Todolist\UseCase\MarkTodoAsDoneInteractor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MarkTodoAsDoneInteractorSpec extends ObjectBehavior
{
    function let(TodoList $todoList)
    {
        $this->beConstructedWith($todoList);
    }

    function it_mark_todo_as_done(TodoList $todoList)
    {
        $input = new MarkTodoAsDoneInput('Learn PHPSpec');
        $todo = Todo::add('Learn PHPSpec', 'mahi');
        $todoList->getTodoByName($input->getName())->willReturn($todo);
        $this->__invoke($input);
        $todoList->save(Argument::type(Todo::class))->shouldHaveBeenCalled();
    }
}
