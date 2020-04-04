<?php

namespace Cherif\Todolist\UseCase\Interactor;

use Cherif\Todolist\Entity\TodoList;
use Cherif\Todolist\UseCase\Data\MarkTodoAsDoneInput;
use Cherif\Todolist\UseCase\Data\MarkTodoAsDoneOutput;

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
