<?php

namespace PHPFUI\Input;

/**
 * Simple wrapper for Tel input fields
 */
class Tel extends Input
	{

	/**
	 * Construct a Tel input
	 *
	 * @param \PHPFUI\Page $page to add javascript
	 * @param string $name of the field
	 * @param string $label defaults to empty
	 * @param ?string $value defaults to empty
	 */
	public function __construct(\PHPFUI\Page $page, string $name, string $label = '', ?string $value = '')
		{
		$page->addTailScript('/js/jquery.mask.js');
		$page->addJavaScript("$('input[type=\"tel\"').mask('(000) 000-0000');");
		parent::__construct('tel', $name, $label, $value);
		$this->setDataMask($page, '(000) 000-0000');
		}
	}
