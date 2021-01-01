<?php

namespace PHPFUI;

class SubHeader extends \PHPFUI\Header
	{
	/**
	 * Simple wrapper for a <H3> element
	 *
	 * @param string $title of the headline
	 */
	public function __construct(string $title)
		{
		parent::__construct($title, 3);
		}
	}
