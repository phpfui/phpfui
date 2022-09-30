<?php

namespace PHPFUI;

/**
 * A simple wrapper for ProgressBar
 */
class ProgressBar extends \PHPFUI\HTML5Element
	{
	private int $current = 0;

	private int $max = 100;

	private int $min = 0;

	private ?\PHPFUI\HTML5Element $meter = null;

	private ?\PHPFUI\HTML5Element $label = null;

	/**
	 * Construct a ProgressBar.  Defaults to 0%
	 */
	public function __construct(private string $labelText = '')
		{
		parent::__construct('div');
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

	public function setCurrent(int $current) : static
		{
		$this->current = $current;

		if (! $this->labelText)
			{
			$this->labelText = (string)$current;
			}

		return $this;
		}

	public function setMaximum(int $max = 100) : static
		{
		$this->max = $max;

		return $this;
		}

	public function setMinimum(int $min = 0) : static
		{
		$this->min = $min;

		return $this;
		}

	/**
	 * Set the original percentage
	 */
	public function setPercent(int $width) : static
		{
		$this->current = \max($this->min, \min($this->max, $width));

		return $this;
		}

	protected function getStart() : string
		{
		$this->setAttribute('aria-valuetext', $this->labelText);
		$this->setAttribute('aria-valuenow', (string)$this->current);
		$this->setAttribute('aria-valuemin', (string)$this->min);
		$this->setAttribute('aria-valuemax', (string)$this->max);

		$this->add($this->getMeter());

		return parent::getStart();
		}
	}
