<?php

namespace PHPFUI;

class Slider extends HTML5Element
	{
	private $max = 100;

	private $min = 0;
	private $sliderHangle = null;
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
		$this->sliderHangle = $handle ? : new SliderHandle($value);
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
		$this->sliderHangle = $handle;

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
			$this->sliderHangle->addAttribute('aria-valuemax', $this->max);
			$this->sliderHangle->addAttribute('aria-valuemin', $this->min);
			$this->sliderHangle->addAttribute('aria-valuenow', $this->value);
			$this->setAttribute('data-initial-end', $this->sliderHangle->getValue());
			$this->add($this->sliderHangle);
			$this->add("<span class='slider-fill' data-slider-fill></span>");

			if ($this->sliderHangle && ! $this->sliderHangle->getBind())
				{
				$this->add($this->sliderHangle->getInput());
				}
			}

		return parent::getStart();
		}
	}
