<?php

namespace PHPFUI;

/**
 * Submit buttons are actual buttons.  Due to the implementation of Foundation 6.6
 * they can not be input fields, but will function like a traditional input type.
 */
class Submit extends \PHPFUI\Button
	{
	/**
	 * @param string $text of button, defaults to 'Save'
	 * @param string $name of field to be submitted, will be 'submit' unless provided
	 */
	public function __construct(string $text = 'Save', string $name = 'submit')
		{
		parent::__construct($text);
		$this->addClass('radius');
		$this->addClass('submit');
		$this->deleteAttribute('type');
		$this->addAttribute('value', $text);
		$this->addAttribute('name', $name);
		$this->addAttribute('onkeypress', 'return event.keyCode!=13;');
		}

	/**
	 * Return true if this submit button was pressed based on parameters passed (normally $_POST)
	 *
	 * @param array<string, string> $parameters
	 */
	public function submitted(array $parameters) : bool
		{
		return isset($parameters[$this->getAttribute('name')]) && $parameters[$this->getAttribute('name')] == $this->getAttribute('value');
		}
	}
