<?php

namespace PHPFUI;

/**
 * Simple wrapper for grid-x
 */
class GridX extends \PHPFUI\HTML5Element
	{
	public function __construct()
		{
		parent::__construct('div');
		$this->addClass('grid-x');
		}

	public function setMargin() : GridX
		{
		$this->addClass('grid-margin-x');

		return $this;
		}
	}
