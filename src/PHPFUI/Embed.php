<?php

namespace PHPFUI;

/**
 * Simple wrapper for FlexVideo
 */
class Embed extends \PHPFUI\HTML5Element
	{
	public function __construct(string $ratio = 'widescreen')
		{
		parent::__construct('div');
		$this->addClass('responsive-embed');
		$this->setRatio($ratio);
		}

	/**
	 * Set the aspect ratio
	 *
	 * @param string $ratio must be one of vertical, panorama, square, widescreen
	 */
	public function setRatio(string $ratio) : static
		{
		$validRatios = ['vertical',
			'panorama',
			'square',
			'widescreen', ];

		if (! \in_array($ratio, $validRatios))
			{
			throw new \Exception(__METHOD__ . ': $ratio must be one of (' . \implode(',', $validRatios) . ')');
			}

		$this->addClass($ratio);

		return $this;
		}
	}
