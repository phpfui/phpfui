<?php

namespace PHPFUI;

class SliderHandle extends \PHPFUI\HTML5Element
	{
	private ?\PHPFUI\HTML5Element $input = null;

	/**
	 * @param int $value of the slider on initializion
	 * @param Input $bind Input field to update when the slider is changed.
	 */
	public function __construct(private int $value = 0, private ?\PHPFUI\Input $bind = null)
		{
		parent::__construct('span');
		$this->addClass('slider-handle');
		$this->setAttribute('data-slider-handle');
		$this->setAttribute('role', 'slider');
		$this->setAttribute('tabindex', '1');

		if ($bind)
			{
			$this->addAttribute('aria-controls', $bind->getId());
			$bind->setValue((string)$value);
			}
		else
			{
			$this->input = new \PHPFUI\HTML5Element('input');
			$this->input->getId();
			$this->input->setAttribute('type', 'hidden');
			$this->input->setAttribute('value', (string)$value);
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
