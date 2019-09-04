<?php

namespace PHPFUI;

class RangeSlider extends HTML5Element
	{

	private $hidden;
	private $page;

	/**
	 * Construct a RangeSlider
	 *
	 * @param Page $page requires JS
	 * @param string $name of the field
	 * @param HTML5Element $display where the current value will be
	 *                                     displayed
	 * @param int $value initial value, default 0
	 */
	public function __construct(Page $page, string $name, HTML5Element $display, int $value = 0)
		{
		parent::__construct('div');
		$this->addClass('range-slider');
		$this->addAttribute('data-slider');
		$this->page = $page;
		$display->addClass('range-slider-active-segment');
		$this->addAttribute('data-options', "display_selector:#{$display->getId()};");
		$this->hidden = new \PHPFUI\Input\Hidden($name, $value);
		$display->add($value);
		$this->addAttribute('data-options', "initial:{$value};");
		}

	/**
	 * Set the end point (maximum)
	 */
	public function setEnd($end = 100) : RangeSlider
		{
		$end = (int)$end;
		$this->addAttribute('data-options', "end:{$end};");

		return $this;
		}

	/**
	 * Set the start (minumum)
	 */
	public function setStart(int $start = 1) : RangeSlider
		{
		$start = (int)$start;
		$this->addAttribute('data-options', "start:{$start};");

		return $this;
		}

	/**
	 * Set the step for the slider
	 */
	public function setStep(int $step = 1) : RangeSlider
		{
		$step = (int)$step;
		$this->addAttribute('data-options', "step:{$step};");

		return $this;
		}

	/**
	 * Make the slider vertical
	 */
	public function setVertical() : RangeSlider
		{
		$this->addClass('vertical-range');

		return $this;
		}

	protected function getBody() : string
		{
		$output = '<span class="range-slider-handle" role="slider" tabindex="0"></span>';
		$output .= $this->hidden;

		return $output;
		}

	}
