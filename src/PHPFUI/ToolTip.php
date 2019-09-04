<?php

namespace PHPFUI;

/**
 * ToolTips are very handy.  They are disabled by default for
 * mobile
 */
class ToolTip extends HTML5Element
	{

	/**
	 * Construct a ToolTip
	 *
	 * @param mixed $content that needs a tooltip
	 * @param string $tip text
	 */
	public function __construct($content, string $tip)
		{
		parent::__construct('span');
		$this->addClass('has-tip');
		$this->add($content);
		$this->addAttribute('title', TextHelper::htmlentities($tip));
		$this->addAttribute('data-tooltip');
		$this->addAttribute('aria-haspopup', 'true');
		$this->addAttribute('tabindex', '1');
		$this->addAttribute('data-disable-hover', 'false');
		}

	}
