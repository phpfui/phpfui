<?php

namespace PHPFUI;

/**
 * Simple wrapper for headers
 */
class Header extends \PHPFUI\HTML5Element
	{
	/**
	 * Constuct a header with a default size of 2
	 *
	 * @param string $title of header
	 * @param int $size of header, default 2
	 */
	public function __construct(string $title, int $size = 2)
		{
		$size = \max(1, $size);
		$size = \min(6, $size);
		parent::__construct("h{$size}");
		$this->add($title);
		}
	}
