<?php

namespace PHPFUI;

/**
 * Simple wrapper for FlexVideo
 */
class Embed extends HTML5Element
	{

	public function __construct(?HTML5Element $video = null)
    {
    parent::__construct('div');
    $this->addClass('responsive-embed');
		$this->add($video);
    }

	public function setRatio(string $ratio) : Embed
		{
		$validRatios = ['vertical',
										'panorama',
										'square',
										'widescreen',];

		if (! in_array($ratio, $validRatios))
			{
			throw new \Exception(__METHOD__ . ': $ratio must be one of (' . implode(',', $validRatios) . ')');
			}
		$this->addClass($ratio);

		return $this;
		}

	}
