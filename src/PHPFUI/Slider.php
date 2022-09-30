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

	private bool $vertical = false;

	/**
	 * @param int $value the initial slider value
	 * @param SliderHandle $handle an optional slider handle. You must supply this if you want a field to be updated by slider changes.
	 */
	public function __construct(private int $value = 0, ?\PHPFUI\SliderHandle $handle = null)
		{
		parent::__construct('div');
		$this->addClass('slider');
		$this->setAttribute('data-slider');
		$this->sliderHandle = $handle ?: new \PHPFUI\SliderHandle($value);
		}

	/**
	 * The max allowed value
	 */
	public function setMax(int $max = 100) : static
		{
		$this->max = $max;

		return $this;
		}

	/**
	 * The min allowed value
	 */
	public function setMin(int $min = 0) : static
		{
		$this->min = $min;

		return $this;
		}

	/**
	 * @param string $function algorithm used for non linear function, must be either log or pow
	 */
	public function setNonLinear(int $base = 5, string $function = 'log') : static
		{
		$functions = ['log',
			'pow', ];

		if (! \in_array($function, $functions))
			{
			throw new \Exception('ERROR: ' . __METHOD__ . ' $function must be ' . \implode(' or ', $functions));
			}

		$this->setAttribute('data-position-value-function', $function);
		$this->setAttribute('data-non-linear-base', (string)$base);

		return $this;
		}

	/**
	 * Specify a range handle
	 */
	public function setRangeHandle(SliderHandle $handle) : static
		{
		$this->rangeHandle = $handle;

		return $this;
		}

	/**
	 * Set the step up or down
	 */
	public function setStep(int $step = 1) : static
		{
		$this->step = $step;

		return $this;
		}

	/**
	 * Set the initial value for the slider
	 */
	public function setValue(int $value) : static
		{
		$this->value = $value;

		return $this;
		}

	/**
	 * Set the slider to be vertical
	 */
	public function setVertical(bool $vertical = true) : static
		{
		$this->vertical = $vertical;

		return $this;
		}

	protected function getStart() : string
		{
		if (! $this->started)
			{
			$this->started = true;
			$this->setAttribute('data-initial-start', (string)$this->value);
			$this->setAttribute('data-start', (string)$this->min);
			$this->setAttribute('data-end', (string)$this->max);
			$this->setAttribute('data-step', (string)$this->step);

			if ($this->vertical)
				{
				$this->addClass('vertical');
				$this->setAttribute('data-vertical', 'true');
				}

			$this->sliderHandle->setAttribute('aria-valuemax', (string)$this->max);
			$this->sliderHandle->setAttribute('aria-valuemin', (string)$this->min);
			$this->sliderHandle->setAttribute('aria-valuenow', (string)$this->value);
			$this->setAttribute('data-initial-end', (string)$this->sliderHandle->getValue());
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
				$this->setAttribute('data-initial-end', (string)$this->rangeHandle->getValue());
				$this->rangeHandle->setAttribute('aria-valuemax', (string)$this->max);
				$this->rangeHandle->setAttribute('aria-valuemin', (string)$this->min);
				$this->rangeHandle->setAttribute('aria-valuenow', (string)$this->rangeHandle->getValue());
				}
			}

		return parent::getStart();
		}
	}
