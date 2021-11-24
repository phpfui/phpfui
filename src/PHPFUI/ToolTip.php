<?php

namespace PHPFUI;

/**
 * ToolTips are very handy.  They are disabled by default for mobile.
 */
class ToolTip extends \PHPFUI\HTML5Element
	{
	/**
	 * @param mixed $content that needs a tooltip
	 * @param string $tip text of the tip. Do not include markup as it will not be rendered correctly.
	 */
	public function __construct($content, string $tip)
		{
		parent::__construct('span');
		$this->addClass('has-tip');
		$this->add($content);
		$this->addAttribute('title', \PHPFUI\TextHelper::htmlentities($tip));
		$this->addAttribute('data-tooltip');
		$this->addAttribute('aria-haspopup', 'true');
		$this->addAttribute('data-disable-hover', 'false');
		}
	}
