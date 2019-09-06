<?php

namespace PHPFUI;

/**
 * Simple wrapper for headers
 */
class Header extends HTML5Element
	{

	/**
	 * Constuct a header with a default size of 2
	 *
	 * @param string $title of header
	 * @param int $size of header, default 2
	 */
	public function __construct($title, $size = 2)
		{
		$size = max(1, (int) $size);
		$size = min(6, $size);
		parent::__construct("h{$size}");
		$this->add($title);
		}

	}
