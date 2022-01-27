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

		$src = \file($bt[0]['file']);
		$line = $src[$bt[0]['line'] - 1] ?? '';
		\preg_match('#Debug\((.+)\)#', $line, $match);
		$max = \strlen($match[1] ?? 0);
		$varname = '';
		$c = 0;

		for ($i = 0; $i < $max; $i++)
			{
			if ('(' == ($match[1][$i] ?? ''))
				{
				$c++;
				}
			elseif (')' == ($match[1][$i] ?? ''))
				{
				$c--;
				}

			if ($c < 0)
				{
				break;
				}
			$varname .= ($match[1][$i] ?? '');
			}

		$this->add($location . $message . $varname . '=' . \htmlspecialchars(\print_r($variable, true)));
		}
	}
