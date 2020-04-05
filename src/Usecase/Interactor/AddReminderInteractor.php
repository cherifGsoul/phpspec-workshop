<?php

namespace Cherif\Todo\UseCase\Interactor;

use Cherif\Todo\Entity\TodoList;
use Cherif\Todo\UseCase\Data\AddReminderInput;
use Cherif\Todo\UseCase\Data\AddReminderOutput;
use DateTimeImmutable;
use DateTimeZone;
use InvalidArgumentException;

class AddReminderInteractor
{
    private $todoList;

    public function __construct(TodoList $todoList)
    {
        $this->todoList = $todoList;
    }

    public function handle(AddReminderInput $input)
    {
        $todo = $this->todoList->getForName($input->getName());

        
        $reminder = DateTimeImmutable::createFromFormat(
            'd/m/Y', 
            $input->getDate(),
            new DateTimeZone('Africa/Algiers')
        );
        
        try {
            $todo->addReminder($reminder, $input->getOwner());
            $this->todoList->save($todo);
            return new AddReminderOutput($todo->getName(), $todo->getOwner(), $todo->getReminder());
        } catch (\Throwable $th) {
            throw new InvalidArgumentException($th->getMessage());
        }
    }
}
