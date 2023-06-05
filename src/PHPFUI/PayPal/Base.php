<?php

namespace PHPFUI\PayPal;

abstract class Base
	{
	/** @var array<string, string | array<string>> */
	protected static array $validFields = [];

	/** @var array<string, string> */
	private array $data = [];

	/** @var array<string, true> */
	private static array $scalars = [
		'boolean' => true,
		'double' => true,
		'integer' => true,
		'string' => true,
	];

	/** @var array<string, string> */
	private array $setFields = [];

	public function __construct()
		{
		foreach (static::$validFields as $field => $type)
			{
			if (! \is_array($type) && ! isset(self::$scalars[$type]))
				{
				$this->data[$field] = new $type();
				}
			}
		}

	/**
	 * Unset fields will return null
	 */
	public function __get(string $field) : mixed
		{
		if (! isset(static::$validFields[$field]))
			{
			throw new \Exception("{$field} is not a valid field for " . static::class);
			}

		$this->setFields[$field] = true;

		return $this->data[$field] ?? null;
		}

	public function __set(string $field, mixed $value) : void
		{
		$expectedType = static::$validFields[$field] ?? null;

		if (null === $expectedType)
			{
			throw new \Exception("{$field} is not a valid field for " . static::class);
			}
		$type = \gettype($value);

		if ('object' == $type)
			{
			$type = $value::class;
			}

		if (\is_array($expectedType))
			{
			if (! \in_array($value, $expectedType))
				{
				throw new \Exception("{$field} is {$value} but must be one of " . \implode(', ', $expectedType) . ' for ' . static::class);
				}
			}
		elseif ($expectedType != $type)
			{
			throw new \Exception("{$field} is of type {$type} but should be type {$expectedType} for " . static::class);
			}
		// Do additional formatting
		switch ($type)
			{
			case 'string':
				// limit strings to 127 characters
				$value = \substr($value, 0, 127);

				break;

			case 'double':
				// 2 decimal paces
				$value = \number_format($value, 2);

				break;
			}

		$this->setFields[$field] = true;
		$this->data[$field] = $value;
		}

	/** @return array<string, mixed> */
	public function getData() : array
		{
		$result = [];

		foreach ($this->data as $field => $value)
			{
			if (! empty($this->setFields[$field]))
				{
				if ('object' == \gettype($value))
					{
					$value = $value->getData();
					}
				$result[$field] = $value;
				}
			}

		return $result;
		}

	public function getJSON() : string
		{
		return \json_encode($this->getData(), JSON_PRETTY_PRINT);
		}

	/**
	 * Return all the valid fields for the object. Index is field name and value is the type.
	 * @return array<string, string>
	 */
	public function getValidFields() : array
		{
		return static::$validFields;
		}
	}
