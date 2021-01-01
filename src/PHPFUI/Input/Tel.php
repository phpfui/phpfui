<?php

namespace PHPFUI\Input;

/**
 * Simple wrapper for Tel input fields
 */
class Tel extends \PHPFUI\Input\Input
	{
	/**
	 * Construct a Tel input
	 *
	 * @param \PHPFUI\Interfaces\Page $page to add javascript
	 * @param string $name of the field
	 * @param string $label defaults to empty
	 * @param ?string $value defaults to empty
	 */
	public function __construct(\PHPFUI\Interfaces\Page $page, string $name, string $label = '', ?string $value = '')
		{
		parent::__construct('tel', $name, $label, $value);
		$this->setDataMask($page, '(000) 000-0000');
		}
	}
