<?php

namespace PHPFUI;

/**
 * Wrapper for Font Awesome icons
 *
 * @depreciated 6.1.0 Icon will become the base class and no
 *  						longer support Font Awesome V4, use FAIcon for
 *  						Font Awesome 5 icons
 */
class Icon extends \PHPFUI\IconBase
	{
	/**
	 * Construct an Icon.
	 *
	 * @param string $icon the bare name of the icon as documented
	 *               by Font Awesome
	 * @param string $link optional link
	 */
	public function __construct(string $icon, string $link = '')
		{
		parent::__construct('', $link);
		$this->addClass('fa');
		$this->addClass('fa-2x');
		$this->addClass('fa-' . $icon);
		}
	}
