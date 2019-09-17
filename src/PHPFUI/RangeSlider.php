<?php

namespace PHPFUI;

class RangeSlider extends HTML5Element
	{
	private $end = 100;

	private $hidden;
	private $page;
	private $start = 1;
	private $value;

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
		$this->value = $value;
		$this->addClass('range-slider');
		$this->addAttribute('data-slider');
		$this->page = $page;
		$display->addClass('range-slider-active-segment');
		$this->addAttribute('data-options', "display_selector:#{$display->getId()};");
		$this->hidden = new \PHPFUI\Input\Hidden($name, $this->value);
		$display->add($this->value);
		$this->addAttribute('data-options', "initial:{$this->value};");
		}

	/**
	 * Set the end point (maximum)
	 */
	public function setEnd(int $end = 100) : RangeSlider
		{
		$this->end = $end;
		$this->addAttribute('data-options', "end:{$this->end};");

		return $this;
		}

	/**
	 * Set the start (minumum)
	 */
	public function setStart(int $start = 1) : RangeSlider
		{
		$this->start = $start;
		$this->addAttribute('data-options', "start:{$this->start};");

		return $this;
		}

	/**
	 * Set the step for the slider
	 */
	public function setStep(int $step = 1) : RangeSlider
		{
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
		$output = "<span class='range-slider-handle' role='slider' tabindex='0' aria-valuemax='{$this->end}' aria-valuemin='{$this->start}' aria-valuenow='{$this->value}'></span>";
		$output .= $this->hidden;

		return $output;
		}
	}
