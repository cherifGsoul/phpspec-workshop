<?php

namespace spec\Cherif\Todolist\Usecase;

use Cherif\Todolist\Domain\Model\Todo;
use Cherif\Todolist\Domain\Model\TodoList;
use Cherif\Todolist\Usecase\Data\MarkTodoAsDoneInput;
use Cherif\Todolist\Usecase\MarkTodoAsDoneInteractor;
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
