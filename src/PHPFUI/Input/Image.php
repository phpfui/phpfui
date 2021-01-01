<?php

namespace PHPFUI\Input;

/**
 * Simple wrapper for Image input fields
 */
class Image extends \PHPFUI\HTML5Element
	{
  /**
   * Construct a Image input
   *
   * @param string $src path to image
   */
	public function __construct(string $src, string $alt = '')
		{
		parent::__construct('input');
		$this->addAttribute('type', 'image');
		$this->addAttribute('src', $src);

		if (empty($alt))
			{
			$alt = $src;
			}

		$this->addAttribute('alt', $alt);
		}
	}
