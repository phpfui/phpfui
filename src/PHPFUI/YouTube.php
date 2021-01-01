<?php

namespace PHPFUI;

/**
 * Simple wrapper for YouTube videos
 */
class YouTube extends \PHPFUI\Embed
	{
  /**
   * Just pass the video code and we do the rest
   *
   * @param string $videoCode unique identifier from YouTube
   */
	public function __construct(string $videoCode, string $ratio = 'widescreen')
		{
		parent::__construct($ratio);
		$iframe = new HTML5Element('iframe');
		$iframe->addAttribute('allowfullscreen');
		$iframe->setAttribute('src', "https://www.youtube.com/embed/{$videoCode}");
		$this->add($iframe);
		}
	}
