<?php

namespace PHPFUI;

/**
 * A quick debug message. Just new with the variable and optional message.  Add to anything to output. Will wrap with pre tags for readability.
 */
class Debug
	{
	private $message = '';

	/**
	 * Make a debug message
	 *
	 * @param mixed $variable what you want to debug
	 * @param string $message extra debug message
	 */
	public function __construct($variable, string $message = '')
		{
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
		$this->message = $location . $message . \print_r($variable, true);
		}

	public function __toString() : string
		{
		return '<pre>' . \htmlspecialchars($this->message) . '</pre>';
		}
	}
