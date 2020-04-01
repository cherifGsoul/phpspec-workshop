<?php

namespace Cherif\Todolist\Domain\Model;

interface TodoList
{

    public function save(Todo $todo);

    public function getTodoByName($argument1);
}
