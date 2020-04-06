<?php

namespace Cherif\Todo\UseCase\Data;

class AddReminderInput
{
	private $name;
	private $owner;
	private $date;

	public function __construct(string $name, string $owner, string $date)
	{
		$this->name = $name;
		$this->owner = $owner;
		$this->date = $date;
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
	 * Get the value of date
	 */ 
	public function getDate()
	{
		return $this->date;
	}
}