<?php

namespace PHPFUI;

class SliderHandle extends \PHPFUI\HTML5Element
	{
	private ?\PHPFUI\Input $bind = null;

	private ?\PHPFUI\HTML5Element $input = null;

	private int $value;

	/**
	 * @param int $value of the slider on initializion
	 * @param Input $bind Input field to update when the slider is changed.
	 */
	public function __construct(int $value = 0, ?\PHPFUI\Input $bind = null)
		{
		parent::__construct('span');
		$this->addClass('slider-handle');
		$this->setAttribute('data-slider-handle');
		$this->setAttribute('role', 'slider');
		$this->setAttribute('tabindex', 1);
		$this->value = $value;
		$this->bind = $bind;

		if ($bind)
			{
			$this->addAttribute('aria-controls', $bind->getId());
			$bind->setValue($value);
			}
		else
			{
			$this->input = new \PHPFUI\HTML5Element('input');
			$this->input->getId();
			$this->input->setAttribute('type', 'hidden');
			$this->input->setAttribute('value', $value);
			}
		}

	/**
	 * Get the bound input field
	 */
	public function getBind() : ?Input
		{
		return $this->bind;
		}

	/**
	 * Get the hidden input field if no binding was set up. Could be null.
	 */
	public function getInput() : ?HTML5Element
		{
		return $this->input;
		}

	/**
	 * Get the initialized value of the slider
	 */
	public function getValue() : int
		{
		return $this->value;
		}
	}
