<?php

namespace PHPFUI;

/**
 * Simple abstract wrapper for a list (OL or UL tags)
 */
abstract class HTMLList extends \PHPFUI\HTML5Element
	{
	public function __construct(string $type)
		{
		parent::__construct($type);
		}

	/**
	 * Adds a ListItem to the list
	 */
	public function addItem(ListItem $item) : static
		{
		$this->add($item);

		return $this;
		}
	}
