<?php

namespace PHPFUI;

/**
 * A simple wrapper for ProgressBar
 */
class ProgressBar extends \PHPFUI\HTML5Element
	{
	private $current = 0;

	private $max = 100;

	private $min = 0;

	private $meter = null;

	private $labelText = '';

	private $label = null;

	/**
	 * Construct a ProgressBar.  Defaults to 0%
	 */
	public function __construct(string $label = '')
		{
		parent::__construct('div');
		$this->labelText = $label;
		$this->addClass('primary');
		$this->addClass('progress');
		$this->addAttribute('role', 'progressbar');
		$this->addAttribute('tabindex', '0');
		}

	public function getLabel() : \PHPFUI\HTML5Element
		{
		if (! $this->label)
			{
			$this->label = new \PHPFUI\HTML5Element('span');
			$this->label->add($this->labelText);
			$this->label->addClass('progress-meter-text');
			}

		return $this->label;
		}

	public function getMeter() : \PHPFUI\HTML5Element
		{
		if (! $this->meter)
			{
			$this->meter = new \PHPFUI\HTML5Element('div');
			$this->meter->addClass('progress-meter');
			$this->meter->setAttribute('style', 'width:' . $this->current . '%');
			$this->meter->add($this->getLabel());
			}

		return $this->meter;
		}

	public function setCurrent(int $current) : ProgressBar
		{
		$this->current = $current;

		if (! $this->labelText)
			{
			$this->labelText = $current;
			}

		return $this;
		}

	public function setMaximum(int $max = 100) : ProgressBar
		{
		$this->max = $max;

		return $this;
		}

	public function setMinimum(int $min = 0) : ProgressBar
		{
		$this->min = $min;

		return $this;
		}

	/**
	 * Set the original percentage
	 */
	public function setPercent(int $width) : ProgressBar
		{
		$this->current = \max($this->min, \min($this->max, $width));

		return $this;
		}

	protected function getStart() : string
		{
		$this->setAttribute('aria-valuetext', $this->labelText);
		$this->setAttribute('aria-valuenow', $this->current);
		$this->setAttribute('aria-valuemin', $this->min);
		$this->setAttribute('aria-valuemax', $this->max);

		$this->add($this->getMeter());

		return parent::getStart();
		}
	}
