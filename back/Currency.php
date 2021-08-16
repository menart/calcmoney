<?php

class Currency
{
	private $numCode;
	private $name;
	private $value;

	/**
	 * @param mixed $numCode
	 */
	public function setNumCode($numCode): void
	{
		$this->numCode = $numCode;
	}

	/**
	 * @param mixed $name
	 */
	public function setName($name): void
	{
		$this->name = $name;
	}

	/**
	 * @param mixed $value
	 */
	public function setValue($value): void
	{
		$this->value = $value;
	}

}