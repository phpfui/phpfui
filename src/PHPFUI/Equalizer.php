<?php

namespace PHPFUI;

class Equalizer extends \PHPFUI\HTML5Element
	{
	private $base;

	private $watchId;

	private static $watchMaster = 0;

	public function __construct(?HTML5Element $base = null)
		{
		if (! $base)
			{
			$base = new GridX();
			}

		parent::__construct($base->getElement());
		$this->base = $base;
		$this->watchId = 'eq-' . (++self::$watchMaster);
		$this->addAttribute('data-equalizer', $this->watchId);
		}

	public function addColumn(HTML5Element $element, string $columnWidthClass = 'medium-4') : Equalizer
		{
		$element->addAttribute('data-equalizer-watch', $this->watchId);
		$cell = new Cell();
		$cell->addClass($columnWidthClass);
		$cell->add($element);
		$this->add($cell);

		return $this;
		}

	public function addElement(HTML5Element $element) : Equalizer
		{
		$element->addAttribute('data-equalizer-watch', $this->watchId);
		$this->add($element);

		return $this;
		}

	public function getStart() : string
		{
		$this->transferClasses($this->base);
		$this->transferAttributes($this->base);

		return parent::getStart();
		}
	}
