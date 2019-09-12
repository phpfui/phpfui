<?php

namespace PHPFUI;

/**
 * A simple wrapper for ProgressBar
 */
class ProgressBar extends HTML5Element
	{
	private $current = 0;

	private $label = '';
	private $max = 100;
	private $min = 0;

	/**
	 * Construct a ProgressBar.  Defaults to 0%
	 */
	public function __construct(string $label = '')
		{
		parent::__construct('div');
		$this->label = $label;
		$this->addClass('primary');
		$this->addClass('progress');
		$this->addAttribute('role', 'progressbar');
		$this->addAttribute('tabindex', '0');
		}

	public function setCurrent(int $current) : ProgressBar
		{
		$this->current = $current;

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
		$this->current = max($this->min, min($this->max, $width));

		return $this;
		}

	protected function getBody() : string
		{
		return '<div class="progress-meter" style="width:' . $this->current . '%"><p class="progress-meter-text">' . $this->label . '</p></div>';
		}

	protected function getStart() : string
		{
		if ('' === $this->label)
			{
			$this->label = "{$this->current}%";
			}
		$this->setAttribute('aria-valuetext', $this->label);
		$this->setAttribute('aria-valuenow', $this->current);
		$this->setAttribute('aria-valuemin', $this->min);
		$this->setAttribute('aria-valuemax', $this->max);

		return parent::getStart();
		}

	}
