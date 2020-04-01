<?php

namespace Cherif\Todolist\Usecase;

use Cherif\Todolist\Domain\Model\Todo;
use Cherif\Todolist\Domain\Model\TodoList;
use Cherif\Todolist\Usecase\Data\AddTodoInput;
use Cherif\Todolist\Usecase\Data\AddTodoOutput;

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
