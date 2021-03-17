<?php

namespace PHPFUI;

/**
 * A cancel button which will close a reveal
 */
class Cancel extends \PHPFUI\Button
	{
  /**
   * Construct a cancel button
   *
   * @param string $name defaults to 'Cancel'
   */
	public function __construct(string $name = 'Cancel')
		{
		parent::__construct($name, '#');
		$this->addAttribute('data-close');
		}
	}
