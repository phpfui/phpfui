<?php

namespace PHPFUI;

/**
 * Wrapper for Font Awesome V5 icons
 */
class FAIcon extends \PHPFUI\IconBase
	{
	private static $prefixes = [
		'fas' => true,
		'far' => true,
		'fal' => true,
		'fad' => true,
		'fab' => true,
	];

	/**
	 * Construct an Icon.
	 *
	 * @param string $prefix must be one of fas, far, fal, fad, fab
	 * @param string $icon the bare name of the icon as documented
	 *               by Font Awesome
	 * @param string $link optional link
	 */
	public function __construct(string $prefix, string $icon, string $link = '')
		{
		parent::__construct($icon, $link);

		if (! isset(self::$prefixes[$prefix]))
			{
			throw new \Exception("{$prefix} not a valid FontAwesome prefix");
			}
		$this->addClass($prefix);
		$this->addClass('fa-2x');
		$this->addClass('fa-' . $icon);
		}
	}
