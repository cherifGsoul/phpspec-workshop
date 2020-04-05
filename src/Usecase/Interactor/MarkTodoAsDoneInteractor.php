<?php

namespace Cherif\Todo\UseCase\Interactor;

use Cherif\Todo\Entity\TodoList;
use Cherif\Todo\UseCase\Data\MarkTodoAsDoneInput;
use Cherif\Todo\UseCase\Data\MarkTodoAsDoneOutput;
use InvalidArgumentException;

class MarkTodoAsDoneInteractor
{
    private $todoList; 

    public function __construct(TodoList $todoList)
    {
        $this->todoList = $todoList;
    }

    public function handle(MarkTodoAsDoneInput $input)
    {
        $todo = $this->todoList->getForName($input->getName());
        try {
            $todo->markAsDone($input->getOwner());
            $this->todoList->save($todo);
            return new MarkTodoAsDoneOutput($todo->getName(), $todo->getOwner());
        } catch (\Throwable $th) {
            throw new InvalidArgumentException($th->getMessage());
        }
    }
}
