<?php

namespace PHPFUI;

/**
 * Simple wrapper for YouTube videos
 */
class YouTube extends HTML5Element
	{

	/**
	 * Just pass the video code and we do the rest
	 *
	 * @param string $videoCode unique identifier from YouTube
	 */
	public function __construct(string $videoCode)
		{
		parent::__construct('iframe');
		$this->setAttribute('frameborder', '0');
		$this->addAttribute('allowfullscreen');
		$this->setAttribute('src', "https://www.youtube.com/embed/{$videoCode}");
		}

	}
