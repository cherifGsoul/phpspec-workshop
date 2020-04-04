<?php

namespace Cherif\Todolist\UseCase\Interactor;

use Cherif\Todolist\Entity\Todo;
use Cherif\Todolist\Entity\TodoList;
use Cherif\Todolist\UseCase\Data\AddTodoInput;
use Cherif\Todolist\UseCase\Data\AddTodoOutput;

class AddTodoInteractor
{
    private $todoList;

    public function __construct(TodoList $todoList)
    {
        $this->todoList = $todoList;
    }
    public function __invoke(AddTodoInput $input): AddTodoOutput
    {
        $todo = Todo::add($input->getName(), $input->getOwner());
        $this->todoList->save($todo);
        return new AddTodoOutput($todo->getName(), $todo->getOwner());
    }
}
