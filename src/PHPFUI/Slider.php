<?php

namespace PHPFUI;

class Slider extends HTML5Element
	{
	private $handle;
	private $max = 100;

	private $min = 0;
	private $rangeHandle = null;
	private $started = false;
	private $step = 1;
	private $value;
	private $vertical = false;

	public function __construct(Page $page, int $value = 0, ?SliderHandle $handle = null)
		{
		parent::__construct('div');
		$this->value = $value;
		$this->addClass('slider');
		$this->setAttribute('data-slider');
		$this->handle = $handle ? : new SliderHandle($value);
		}

	public function setMax(int $max = 100) : Slider
		{
		$this->max = $max;

		return $this;
		}

	public function setMin(int $min = 0) : Slider
		{
		$this->min = $min;

		return $this;
		}

	public function setNonLinear(int $base = 5, string $function = 'log') : Slider
		{
		$functions = ['log',
									'pow'];

		if (! in_array($function, $functions))
			{
			throw new Exception('ERROR: ' . __METHOD__ . ' $function must be ' . implode(' or ', $functions));
			}
		$this->setAttribute('data-position-value-function', $function);
		$this->setAttribute('data-non-linear-base', $base);
		}

	public function setRangeHandle(SliderHandle $handle) : Slider
		{
		$this->rangeHandle = $handle;

		return $this;
		}

	public function setStep(int $step = 1) : Slider
		{
		$this->step = $step;

		return $this;
		}

	public function setValue(int $value) : Slider
		{
		$this->value = $value;

		return $this;
		}

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
			$this->add($this->handle);
			$this->add('<span class="slider-fill" data-slider-fill></span>');

			if ($this->rangeHandle)
				{
				$this->add($this->rangeHandle);
				$this->setAttribute('data-initial-end', $this->rangeHandle->getValue());
				}

			if (! $this->handle->getBind())
				{
				$this->add($this->handle->getInput());
				}

			if ($this->rangeHandle && ! $this->rangeHandle->getBind())
				{
				$this->add($this->rangeHandle->getInput());
				}
			}

		return parent::getStart();
		}

	}
