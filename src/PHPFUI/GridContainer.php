<?php

namespace PHPFUI;

/**
 * Simple wrapper for grid-container
 */
class GridContainer extends \PHPFUI\HTML5Element
	{
	public function __construct()
		{
		parent::__construct('div');
		$this->addClass('grid-container');
		}

	public function setFluid() : GridContainer
		{
		$this->addClass('fluid');

		return $this;
		}

	public function setFull() : GridContainer
		{
		$this->addClass('full');

		return $this;
		}
	}
