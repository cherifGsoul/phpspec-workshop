<?php

namespace Cherif\Todolist\UseCase\Data;

class AddTodoInput
{
	private $name;
	private $owner;

	public function __construct(string $name, string $owner)
	{
		$this->name = $name;
		$this->owner = $owner;
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
}