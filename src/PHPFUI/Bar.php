<?php

namespace PHPFUI;

abstract class Bar extends \PHPFUI\HTML5Element
	{
	protected array $left = [];

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
	public function addLeft($item) : Bar
		{
		$this->left[] = $item;

		return $this;
		}

	/**
	 * Add an item to the right side after previously added item.
	 */
	public function addRight($item) : Bar
		{
		$this->right[] = $item;

		return $this;
		}

	/**
	 * Add an item on the the left before any previously added items
	 */
	public function pushLeft($item) : Bar
		{
		$this->left[] = $item;

		return $this;
		}

	/**
	 * Adds an item before the other items on the right.
	 */
	public function pushRight($item) : Bar
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
