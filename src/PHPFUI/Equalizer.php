<?php

namespace PHPFUI;

class Equalizer extends \PHPFUI\HTML5Element
	{
	private ?\PHPFUI\HTML5Element $base;

	private string $watchId;

	private static int $watchMaster = 0;

	public function __construct(?\PHPFUI\HTML5Element $base = null)
		{
		if (! $base)
			{
			$base = new \PHPFUI\GridX();
			}

		parent::__construct($base->getElement());
		$this->base = $base;
		$this->watchId = 'eq-' . (++self::$watchMaster);
		$this->addAttribute('data-equalizer', $this->watchId);
		}

	public function addColumn(\PHPFUI\HTML5Element $element, string $columnWidthClass = 'medium-4') : static
		{
		$element->addAttribute('data-equalizer-watch', $this->watchId);
		$cell = new \PHPFUI\Cell();
		$cell->addClass($columnWidthClass);
		$cell->add($element);
		$this->add($cell);

		return $this;
		}

	public function addElement(\PHPFUI\HTML5Element $element) : static
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
