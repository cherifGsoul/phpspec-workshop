<?php

namespace Cherif\Todo\UseCase\Interactor;

use Cherif\Todo\Entity\TodoList;
use Cherif\Todo\UseCase\Data\AddDeadlineInput;
use Cherif\Todo\UseCase\Data\AddDeadlineOutput;
use DateTimeImmutable;
use DateTimeZone;
use InvalidArgumentException;

class AddDeadlineInteractor
{
    private $todoList;

    public function __construct(TodoList $todoList)
    {
        $this->todoList = $todoList;
    }

    public function handle(AddDeadlineInput $input)
    {
        $todo = $this->todoList->getForName($input->getName());
        $deadline = DateTimeImmutable::createFromFormat(
            'd/m/Y', 
            $input->getDate(),
            new DateTimeZone('Africa/Algiers')
        );
        try {
            $todo->addDeadline($deadline, $input->getOwner());
            $this->todoList->save($todo);
            return new AddDeadlineOutput($todo->getName(), $todo->getOwner(), $todo->getDeadline());
        } catch (\Throwable $th) {
            throw new InvalidArgumentException($th->getMessage());
        }
    }
}
