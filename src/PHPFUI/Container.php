<?php

namespace PHPFUI;

/**
 * A container class that conforms to an interface needed by PHPFUI.  The Container class does not impart any html
 * or other formatting, but simply contains items that will be output in the order they were added to the collection.
 */
class Container implements \Countable, \PHPFUI\Interfaces\Walkable, \Stringable
	{
	use \PHPFUI\Traits\Walkable;

	/** @var array<mixed> */
	private array $items = [];

	/**
	 * Construct a Container.  Any arguments passed to the constructor will be added to the container.
	 */
	public function __construct()
		{
		$this->items = \func_get_args();
		}

	public function __toString() : string
		{
		$output = '';

		foreach ($this->items as $object)
			{
			$output .= $object;
			}

		return $output;
		}

	/**
	 * Add an item to the Container
	 *
	 * @param string|Base $object need to support output interface or __toString
	 */
	public function add(string|\PHPFUI\Base $object) : static
		{
		if (null !== $object)
			{
			$this->items[] = $object;
			}

		return $this;
		}

	/**
	 * Adds to the front of the container
	 *
	 * @param mixed $object should be convertable to string
	 */
	public function addAsFirst(mixed $object) : static
		{
		if (null !== $object)
			{
			\array_unshift($this->items, $object);
			}

		return $this;
		}

	/**
	 * Supports the Countable interface
	 */
	public function count() : int
		{
		return \count($this->items);
		}

	/**
	 * Add an item to the beginning of the Container
	 *
	 * @param string|Base $object need to support output interface or __toString
	 */
	public function prepend(string|\PHPFUI\Base $object) : Container
		{
		return $this->addAsFirst($object);
		}
	}
