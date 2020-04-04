<?php

namespace Cherif\Todo\UseCase\Interactor;

use Cherif\Todo\Entity\Todo;
use Cherif\Todo\Entity\TodoList;
use Cherif\Todo\UseCase\Data\AddTodoInput;
use Cherif\Todo\UseCase\Data\AddTodoOutput;

class AddTodoInteractor
{
    private $todoList;

    public function __construct(TodoList $todoList)
    {
        $this->todoList = $todoList;
    }

    public function handle(AddTodoInput $input)
    {
        $todo = Todo::add($input->getName(), $input->getOwner());
        $this->todoList->save($todo);
        return new AddTodoOutput($todo->getName(), $todo->getOwner());
    }
}
