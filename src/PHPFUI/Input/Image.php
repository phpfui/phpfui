<?php

namespace PHPFUI\Input;

/**
 * Simple wrapper for Image input fields
 */
class Image extends HTML5Element
	{

	/**
	 * Construct a Image input
	 *
	 * @param string $src path to image
	 */
	public function __construct(string $src)
		{
		parent::__construct('input');
		$this->addAttribute('type', 'image');
		$this->addAttribute('src', $src);
		}

	}
