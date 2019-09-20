<?php

namespace PHPFUI;

abstract class Bar extends HTML5Element
	{
	protected $left = [];
	protected $right = [];

	private $className;
	private $started = false;

	/**
	 * Construct a TopBar
	 */
	public function __construct(string $className)
		{
		parent::__construct('div');
		$this->className = $className . '-bar';
		$this->addClass($this->className);
		}

	public function addLeft($item) : Bar
		{
		$this->left[] = $item;

		return $this;
		}

	public function addRight($item) : Bar
		{
		$this->right[] = $item;

		return $this;
		}

	public function pushLeft($item) : Bar
		{
		array_push($this->left, $item);

		return $this;
		}

	public function pushRight($item) : Bar
		{
		array_push($this->right, $item);

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
			$element = new HTML5Element('div');
			$element->addClass($this->className . '-' . $class);

			foreach ($items as $item)
				{
				$element->add($item);
				}
			}

		return $element;
		}
	}
