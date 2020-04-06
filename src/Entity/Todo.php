<?php

namespace Cherif\Todo\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use DomainException;

class Todo
{
    private $name;
    private $owner;
    private $done;
    private $deadline;
    private $reminder;

    /**
     * 
     */
    private function __construct(string $name, string $owner)
    {
        $this->name = $name;
        $this->owner = $owner;
    }

    /**
     * 
     */
    public static function add(string $name, string $owner): Todo
    {
        $todo = new Todo($name, $owner);

        $todo->done = false;

        return $todo;
    }

    /**
     * 
     */
    public function isOpen()
    {
        return !$this->done;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of owner
     */ 
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * 
     */
    public function markAsDone(string $owner)
    {
        if ($owner != $this->owner) {
            throw new DomainException('Only todo owner can mark it as done!');
        }

        if ($this->done) {
            throw new DomainException('The todo is already marked as done!');
        }

        $this->done = true;
    }

    /**
     * 
     */
    public function isDone()
    {
        return $this->done;
    }

    /**
     * 
     */
    public function reopen(string $owner)
    {
        if ($owner != $this->owner) {
            throw new DomainException('Only todo owner can reopen it!');
        }

        if ($this->isOpen()) {
            throw new DomainException('You can only reopen a marked as done todo');
        }
        
        $this->done = false;
    }

    /**
     * 
     */
    public function addDeadline(DateTimeImmutable $deadline, string $owner)
    {
        if ($owner != $this->owner) {
            throw new DomainException('Only todo owner can add deadline');
        }
        
        
        if ($deadline <= new DateTimeImmutable()) {
            throw new DomainException('Todo deadline must be in the futur!');
        }
        
        $this->deadline = $deadline;
    }

    public function hasDeadline(): bool
    {
        return $this->deadline instanceof DateTimeImmutable;
    }

    /**
     * Get the value of deadline
     */ 
    public function getDeadline()
    {
        return $this->deadline;
    }

    public function addReminder(DateTimeImmutable $reminder, string $owner)
    {
        if ($owner != $this->owner) {
            throw new DomainException('Only todo owner can add reminder');
        }

        if ($reminder <= new DateTimeImmutable()) {
            throw new DomainException('Todo reminder must be in the futur!');
        }
        
        if (!$this->hasDeadline()) {
            throw new DomainException('Todo with deadline only can have a reminder!');
        }

        $this->reminder = $reminder;
    }

    public function hasReminder()
    {
        return $this->reminder instanceof DateTimeImmutable;
    }

    /**
     * Get the value of reminder
     */ 
    public function getReminder()
    {
        return $this->reminder;
    }
}
