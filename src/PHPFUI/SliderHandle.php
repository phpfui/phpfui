<?php

namespace PHPFUI;

class SliderHandle extends HTML5Element
	{

	private $bind = null;
	private $input;
	private $value;

	public function __construct(int $value = 0, ?Input $bind = null)
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
			}

		$this->input = new HTML5Element('input');
		$this->input->getId();
		$this->input->setAttribute('type', 'hidden');
		$this->input->setAttribute('value', $value);
		}

	public function getBind() : ?Input
		{
		return $this->bind;
		}

	public function getInput() : HTML5Element
		{
		return $this->input;
		}

	public function getValue() : int
		{
		return $this->value;
		}

	}
