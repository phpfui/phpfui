<?php

namespace PHPFUI\PayPal;

abstract class Base
	{
	protected static $validFields = [];

	private $data = [];

	/**
	 * Unset fields will return null
	 */
	public function __get(string $field)
		{
		if (! isset(static::$validFields[$field]))
			{
			throw new \Exception("{$field} is not a valid field for " . get_class($this));
			}

		return $this->data[$field] ?? null;
		}

	public function __set(string $field, $value) : void
		{
		$expectedType = static::$validFields[$field] ?? null;

		if (null === $expectedType)
			{
			throw new \Exception("{$field} is not a valid field for " . get_class($this));
			}
		$type = gettype($value);

		if ('object' == $type)
			{
			$type = get_class($value);
			}

		if (is_array($expectedType))
			{
			if (! in_array($value, $expectedType))
				{
				throw new \Exception("{$field} is {$value} but must be one of " . implode(', ', $expectedType) . ' for ' . get_class($this));
				}
			}
		elseif ($expectedType != $type)
			{
			throw new \Exception("{$field} is of type {$type} but should be type {$expectedType} for " . get_class($this));
			}
		// Do additional formatting
		switch ($type)
			{
			case 'string':
				// limit strings to 127 characters
				$value = substr($value, 0, 127);

				break;

			case 'double':
				// 2 decimal paces
				$value = number_format($value, 2);

				break;
			}

		$this->data[$field] = $value;
		}

	public function getData() : array
		{
		$result = [];

		foreach ($this->data as $field => $value)
			{
			if ('object' == gettype($value))
				{
				$value = $value->getData();
				}
			$result[$field] = $value;
			}

		return $result;
		}

	public function getJSON() : string
		{
		return json_encode($this->getData(), JSON_PRETTY_PRINT);
		}

	/**
	 * Return all the valid fields for the object. Index is field name and value is the type.
	 */
	public function getValidFields() : array
		{
		return static::$validFields();
		}
	}
