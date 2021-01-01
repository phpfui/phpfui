<?php

namespace PHPFUI;

class Callout extends \PHPFUI\HTML5Element
	{
	/**
	 * Make a call out of a specific type. Add content to with the normal add function.
	 */
	public function __construct(string $type = '')
		{
		parent::__construct('div');
		$this->addClass('callout');

		if ($type)
			{
			$this->addClass($type);
			}
		}
	}
