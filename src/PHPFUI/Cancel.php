<?php

namespace PHPFUI;

/**
 * A cancel button which will close a reveal
 */
class Cancel extends Button
	{

	/**
	 * Construct a cancel button
	 *
	 * @param string $name defaults to 'Cancel'
	 */
	public function __construct($name = 'Cancel')
		{
		parent::__construct('#', $name);
		$this->addClass('close-reveal-reveal');
		}
	}
