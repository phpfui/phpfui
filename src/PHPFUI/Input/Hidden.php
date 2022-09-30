<?php

namespace PHPFUI\Input;

/**
 * Simple wrapper for Hidden input fields
 */
class Hidden extends \PHPFUI\Input\Input
	{
	/**
	 * Construct a Hidden input
	 *
	 * @param string $name of the field
	 * @param ?string $value defaults to empty
	 */
	public function __construct(string $name, ?string $value = '')
		{
		parent::__construct('hidden', $name, '', (string)$value);
		$this->deleteAttribute('onkeypress');
		}
	}
