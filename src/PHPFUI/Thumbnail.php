<?php

namespace PHPFUI;

/**
 * Thumbnails can be a Model link
 */
class Thumbnail extends \PHPFUI\HTML5Element
	{
	/**
	 * @param string $url for optional link
	 */
	public function __construct(Image $img, string $url = '')
		{
		if ($url)
			{
			$this->setElement('a');
			$this->addAttribute('href', $url);
			$this->addClass('thumbnail');
			$this->add($img);
			}
		else
			{
			$this->setElement('img');
			$this->setAttribute('alt', $img->getAttribute('alt'));
			$this->setAttribute('src', $img->getAttribute('src'));
			$this->addClass('thumbnail');
			}
		}
	}
