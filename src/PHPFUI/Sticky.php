<?php

namespace PHPFUI;

class Sticky extends \PHPFUI\HTML5Element
	{
	/**
	 * Create a Sticky object.  You must create it with the parent
	 * object you want that will contain the Sticky element inside. The
	 * Sticky object will be automatically added to the parent.
	 *
	 * You can then add anything you want into the Sticky object.
	 */
	public function __construct(\PHPFUI\HTML5Element $parent)
		{
		parent::__construct('div');
		$this->addClass('sticky');
		$this->addAttribute('data-sticky');
		$parent->addAttribute('data-sticky-container');
		}

	public function addBottomAnchor(string $anchor) : Sticky
		{
		$this->addAttribute('data-btm-anchor', "{$anchor}:top");

		return $this;
		}

	public function addTopAnchor(string $anchor) : Sticky
		{
		$this->addAttribute('data-top-anchor', "{$anchor}:top");

		return $this;
		}
	}
