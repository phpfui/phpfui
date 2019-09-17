<?php

namespace PHPFUI;

class SubHeader extends Header
	{

	/**
	 * Simple wrapper for a <H3> element
	 *
	 * @param string $title of the headline
	 */
	public function __construct($title)
		{
		parent::__construct($title, 3);
		}
	}
