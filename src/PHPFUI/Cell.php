<?php

namespace PHPFUI;

/**
 * Simple wrapper for Cells
 */
class Cell extends \PHPFUI\HTML5Element
	{
	protected int $large;

	protected int $medium;

	protected int $small;

	/**
	 * Construct a Cell.  Pass the number of columns you want an
	 * element to take for each breakpoint.
	 *
	 * **Example:**
	 * ```
	 * $col = new \PHPFUI\Cell(6, 4, 3);
	 * ```
	 * On a small page the item will take up 1/2 the width. On a
	 * medium page 1/3 and on a large page 1/4
	 *
	 * You don't have to specify all parameters, subsequent
	 * parameters will default to the last parameter given.
	 */
	public function __construct(int $small = 0, int $medium = 0, int $large = 0)
		{
		parent::__construct('div');
		$this->addClass('cell');
		$this->small = $small;
		$this->medium = $medium;
		$this->large = $large;
		}

	public function setAuto() : Cell
		{
		$this->addClass('auto');

		return $this;
		}

	public function setLarge(int $type) : Cell
		{
		$this->large = $type;

		return $this;
		}

	public function setMedium(int $type) : Cell
		{
		$this->medium = $type;

		return $this;
		}

	public function setShrink() : Cell
		{
		$this->addClass('shrink');

		return $this;
		}

	public function setSmall(int $type) : Cell
		{
		$this->small = $type;

		return $this;
		}

	protected function getStart() : string
		{
		$this->makeClass('small', $this->small);
		$this->makeClass('medium', $this->medium);
		$this->makeClass('large', $this->large);

		return parent::getStart();
		}

	protected function makeClass(string $size, int $setting) : void
		{
		if ($setting)
			{
			$this->addClass("{$size}-{$setting}");
			}
		}
	}
