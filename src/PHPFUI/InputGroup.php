<?php

namespace PHPFUI;

/**
 * Generic input class with default error handling
 */
class InputGroup extends \PHPFUI\HTML5Element
	{
	public function __construct()
		{
		parent::__construct('div');
		$this->addClass('input-group');
		}

	public function addButton(Button $button) : InputGroup
		{
		$span = new HTML5Element('span');
		$span->addClass('input-group-button');
		$span->add($button);
		$this->add($span);

		return $this;
		}

	public function addInput(Input $input) : InputGroup
		{
		$input->addClass('input-group-field');
		$this->add($input);

		return $this;
		}

	public function addLabel(string $label) : InputGroup
		{
		$span = new HTML5Element('span');
		$span->addClass('input-group-label');
		$span->add($label);
		$this->add($span);

		return $this;
		}
	}
