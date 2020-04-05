<?php

namespace Cherif\Todo\UseCase\Interactor;

use Cherif\Todo\Entity\TodoList;
use Cherif\Todo\UseCase\Data\ReopenTodoInput;
use Cherif\Todo\UseCase\Data\ReopenTodoOutput;
use InvalidArgumentException;

class ReopenTodoInteractor
{
    private $todoList;

    public function __construct(TodoList $todoList)
    {
        $this->todoList = $todoList;
    }

    public function handle(ReopenTodoInput $input): ReopenTodoOutput
    {
        $todo = $this->todoList->getForName($input->getName());
        try {
            $todo->reopen($input->getOwner());
            $this->todoList->save($todo);
            return new ReopenTodoOutput($todo->getName(), $todo->getOwner());
        } catch (\Throwable $th) {
            throw new InvalidArgumentException($th->getMessage());
        }
    }
}
