<?php

namespace Cherif\Todolist\UseCase\Data;

class MarkTodoAsDoneOutput
{
	private $name;

	public function __construct(string $name)
	{
		$this->name = $name;
	}

	

	/**
	 * Get the value of name
	 */ 
	public function getName()
	{
		return $this->name;
	}
}