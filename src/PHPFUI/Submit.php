<?php

namespace PHPFUI;

/**
 * Submit buttons are treated as buttons for PHPFUI purposes, as
 * they look like buttons.  In HTML, they are input fields.
 */
class Submit extends Button
	{

	/**
	 * Construct a Submit button
	 *
	 * @param string $text of button
	 * @param string $name of field to be submitted
	 */
	public function __construct(string $text = 'Save', string $name = 'submit')
		{
		HTML5Element::__construct('input');
		$this->addClass('button');
		$this->addClass('radius');
		$this->addAttribute('value', $text);
		$this->addAttribute('name', $name);
		$this->addAttribute('type', 'submit');
		$this->addAttribute('onkeypress', 'event.keyCode!=13;');
		}
	}
