<?php

namespace PHPFUI;

abstract class Bar extends \PHPFUI\HTML5Element
	{
	/** @var array<mixed> */
	protected array $left = [];

	/** @var array<mixed> */
	protected array $right = [];

	private string $className;

	private bool $started = false;

	public function __construct(string $className)
		{
		parent::__construct('div');
		$this->className = $className . '-bar';
		$this->addClass($this->className);
		}

	/**
	 * Add an item to the left side.
	 */
	public function addLeft(mixed $item) : static
		{
		$this->left[] = $item;

		return $this;
		}

	/**
	 * Add an item to the right side after previously added item.
	 */
	public function addRight(mixed $item) : static
		{
		$this->right[] = $item;

		return $this;
		}

	/**
	 * Add an item on the the left before any previously added items
	 */
	public function pushLeft(mixed $item) : static
		{
		$this->left[] = $item;

		return $this;
		}

	/**
	 * Adds an item before the other items on the right.
	 */
	public function pushRight(mixed $item) : static
		{
		$this->right[] = $item;

		return $this;
		}

	protected function getStart() : string
		{
		if (! $this->started)
			{
			$this->started = true;
			$this->add($this->getSection($this->left, 'left'));
			$this->add($this->getSection($this->right, 'right'));
			}

		return parent::getStart();
		}

	/** @param array<mixed> $items */
	private function getSection(array $items, string $class) : ?HTML5Element
		{
		$element = null;

		if ($items)
			{
			$element = new \PHPFUI\HTML5Element('div');
			$element->addClass($this->className . '-' . $class);

			foreach ($items as $item)
				{
				$element->add($item);
				}
			}

		return $element;
		}
	}
