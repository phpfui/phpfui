<?php

namespace PHPFUI;

class BlockGrid extends \PHPFUI\HTML5Element
	{
	public function __construct(protected int $small = 0, protected int $medium = 0, protected int $large = 0)
		{
		parent::__construct('ul');
		}

	public function addBlock(string $text) : static
		{
		$this->add("<li>{$text}</li>");

		return $this;
		}

	public function setLarge(int $number) : static
		{
		$this->large = $number;

		return $this;
		}

	public function setMedium(int $number) : static
		{
		$this->medium = $number;

		return $this;
		}

	public function setSmall(int $number) : static
		{
		$this->small = $number;

		return $this;
		}

	protected function getStart() : string
		{
		$this->makeClass('small', (string)$this->small);
		$this->makeClass('medium', (string)$this->medium);
		$this->makeClass('large', (string)$this->large);
		$this->addClass('columns');

		return parent::getStart();
		}

	protected function makeClass(string $size, string $setting) : void
		{
		if ($setting)
			{
			$this->addClass("{$size}-block-grid-{$setting}");
			}
		}
	}
