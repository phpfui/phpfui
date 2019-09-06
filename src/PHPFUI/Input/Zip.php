<?php

namespace PHPFUI\Input;

/**
 * A class to handle Zip codes with better mobile validation
 */
class Zip extends Input
	{

	/**
	 * A simple responsive control for a US zip code, 10 digit max. Will display the numeric keyboard on mobile devices.
	 *
	 * @param Page $page need for validation
	 * @param string $name of the field
	 * @param string $label to be displayed to the user
	 * @param ?string $value initial value
	 */
	public function __construct(\PHPFUI\Page $page, string $name, string $label = '', ?string $value = '')
		{
		parent::__construct('tel', $name, $label, $value);
		$this->setAttribute('size', 10);
		$this->setAttribute('maxLength', 10);
		$this->setAttribute('pattern', 'zip');
		$page->addPluginDefault('Abide', 'patterns["zip"]', '/^[0-9-]*$/');

		}

	}
