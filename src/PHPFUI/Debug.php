<?php

namespace PHPFUI;

/**
 * A quick debug message. Just new with the variable and optional message.  Add to anything to output. Will wrap with pre tags for readability.
 */
class Debug extends \PHPFUI\HTML5Element
	{
	/**
	 * Make a debug message
	 *
	 * @param mixed $variable what you want to debug
	 * @param string $message extra debug message
	 */
	public function __construct($variable, string $message = '')
		{
		parent::__construct('pre');
		$location = '';

		if (\strlen($message))
			{
			$message .= ': ';
			}
		$bt = \debug_backtrace();

		if (isset($bt[0]['file']))
			{
			$location = $bt[0]['file'] . ' ' . $bt[0]['line'] . ': ';
			}
		$this->add($location . $message . \htmlspecialchars(\print_r($variable, true)));
		}
	}
