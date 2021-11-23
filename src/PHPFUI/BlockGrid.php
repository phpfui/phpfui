<?php

namespace PHPFUI;

class BlockGrid extends \PHPFUI\HTML5Element
	{
	protected int $large = 0;

	protected int $medium = 0;

	protected int $small = 0;

	public function __construct(int $small = 0, int $medium = 0, int $large = 0)
		{
		parent::__construct('ul');
		$this->small = $small;
		$this->medium = $medium;
		$this->large = $large;
		}

	public function addBlock(string $text) : BlockGrid
		{
		$this->add("<li>{$text}</li>");

		return $this;
		}

	public function setLarge(int $number) : BlockGrid
		{
		$this->large = $number;

		return $this;
		}

	public function setMedium(int $number) : BlockGrid
		{
		$this->medium = $number;

		return $this;
		}

	public function setSmall(int $number) : BlockGrid
		{
		$this->small = $number;

		return $this;
		}

	protected function getStart() : string
		{
		$this->makeClass('small', $this->small);
		$this->makeClass('medium', $this->medium);
		$this->makeClass('large', $this->large);
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
