<?php

namespace Cherif\Todolist\Entity;

interface TodoList
{

    public function save(Todo $todo);

    public function getTodoByName($argument1);
}
