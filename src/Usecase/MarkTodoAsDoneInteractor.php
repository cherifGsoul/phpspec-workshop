<?php

namespace Cherif\Todolist\Usecase;

use Cherif\Todolist\Domain\Model\TodoList;
use Cherif\Todolist\Usecase\Data\MarkTodoAsDoneInput;
use Cherif\Todolist\Usecase\Data\MarkTodoAsDoneOutput;

class MarkTodoAsDoneInteractor
{
    private $todoList;

    public function __construct(TodoList $todoList)
    {
        $this->todoList = $todoList;
    }

    public function __invoke(MarkTodoAsDoneInput $input)
    {
        $todo = $this->todoList->getTodoByName($input->getName());
        $todo->markAsDone();
        $this->todoList->save($todo);
        return new MarkTodoAsDoneOutput($todo->getName());
    }
}
