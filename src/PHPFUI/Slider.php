<?php

namespace PHPFUI;

class Slider extends \PHPFUI\HTML5Element
	{
	private int $max = 100;

	private int $min = 0;

	private ?\PHPFUI\SliderHandle $rangeHandle = null;

	private ?\PHPFUI\SliderHandle $sliderHandle = null;

	private bool $started = false;

	private int $step = 1;

	private int $value;

	private bool $vertical = false;

	/**
	 * @param int $value the initial slider value
	 * @param SliderHandle $handle an optional slider handle. You must supply this if you want a field to be updated by slider changes.
	 */
	public function __construct(int $value = 0, ?\PHPFUI\SliderHandle $handle = null)
		{
		parent::__construct('div');
		$this->value = $value;
		$this->addClass('slider');
		$this->setAttribute('data-slider');
		$this->sliderHandle = $handle ?: new \PHPFUI\SliderHandle($value);
		}

	/**
	 * The max allowed value
	 */
	public function setMax(int $max = 100) : Slider
		{
		$this->max = $max;

		return $this;
		}

	/**
	 * The min allowed value
	 */
	public function setMin(int $min = 0) : Slider
		{
		$this->min = $min;

		return $this;
		}

	/**
	 * @param string $function algorithm used for non linear function, must be either log or pow
	 */
	public function setNonLinear(int $base = 5, string $function = 'log') : Slider
		{
		$functions = ['log',
			'pow', ];

		if (! \in_array($function, $functions))
			{
			throw new \Exception('ERROR: ' . __METHOD__ . ' $function must be ' . \implode(' or ', $functions));
			}

		$this->setAttribute('data-position-value-function', $function);
		$this->setAttribute('data-non-linear-base', $base);

		return $this;
		}

	/**
	 * Specify a range handle
	 */
	public function setRangeHandle(SliderHandle $handle) : Slider
		{
		$this->rangeHandle = $handle;

		return $this;
		}

	/**
	 * Set the step up or down
	 */
	public function setStep(int $step = 1) : Slider
		{
		$this->step = $step;

		return $this;
		}

	/**
	 * Set the initial value for the slider
	 */
	public function setValue(int $value) : Slider
		{
		$this->value = $value;

		return $this;
		}

	/**
	 * Set the slider to be vertical
	 */
	public function setVertical(bool $vertical = true) : Slider
		{
		$this->vertical = $vertical;

		return $this;
		}

	protected function getStart() : string
		{
		if (! $this->started)
			{
			$this->started = true;
			$this->setAttribute('data-initial-start', $this->value);
			$this->setAttribute('data-start', $this->min);
			$this->setAttribute('data-end', $this->max);
			$this->setAttribute('data-step', $this->step);

			if ($this->vertical)
				{
				$this->addClass('vertical');
				$this->setAttribute('data-vertical', 'true');
				}

			$this->sliderHandle->setAttribute('aria-valuemax', $this->max);
			$this->sliderHandle->setAttribute('aria-valuemin', $this->min);
			$this->sliderHandle->setAttribute('aria-valuenow', $this->value);
			$this->setAttribute('data-initial-end', (float)$this->sliderHandle->getValue());
			$this->add($this->sliderHandle);
			$this->add("<span class='slider-fill' data-slider-fill></span>");

			if ($this->rangeHandle)
				{
				$this->add($this->rangeHandle);
				}

			if ($this->sliderHandle->getInput())
				{
				$this->add($this->sliderHandle->getInput());
				}

			if ($this->rangeHandle)
				{
				$endInput = $this->rangeHandle->getInput();

				if ($endInput)
					{
					$this->add($this->rangeHandle->getInput());
					}
				else
					{
					$endInput = $this->rangeHandle->getBind();
					}
				$this->setAttribute('data-initial-end', $this->rangeHandle->getValue());
				$this->rangeHandle->setAttribute('aria-valuemax', $this->max);
				$this->rangeHandle->setAttribute('aria-valuemin', $this->min);
				$this->rangeHandle->setAttribute('aria-valuenow', $this->rangeHandle->getValue());
				}
			}

		return parent::getStart();
		}
	}
