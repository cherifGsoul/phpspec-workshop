<?php

namespace Cherif\Todo\Entity;

use DomainException;

class Todo
{
    private $name;
    private $owner;
    private $done;

    private function __construct(string $name, string $owner)
    {
        $this->name = $name;
        $this->owner = $owner;
    }

    public static function add(string $name, string $owner): Todo
    {
        $todo = new Todo($name, $owner);

        $todo->done = false;

        return $todo;
    }

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

    public function isDone()
    {
        return $this->done;
    }

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
}
