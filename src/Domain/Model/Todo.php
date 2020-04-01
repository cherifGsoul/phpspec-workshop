<?php

namespace Cherif\Todolist\Domain\Model;

class Todo
{
    private $name;
    private $owner;

    private function __construct(string $name, string $owner)
    {
        $this->name = $name;
        $this->owner = $owner;
    }

    public static function add(string $name, string $owner): Todo
    {
        $todo = new Todo($name, $owner);
        $todo->open = true;
        return $todo;
    }

    public function isOpen(): bool
    {
        return $this->open;
    }

    public function markAsDone()
    {
        $this->open = false;
    }

    public function isDone()
    {
        return !$this->isOpen();
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }
}
