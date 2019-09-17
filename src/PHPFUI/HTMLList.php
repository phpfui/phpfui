<?php

namespace PHPFUI;

/**
 * Simple abstract wrapper for a list (OL or UL tags)
 */
abstract class HTMLList extends HTML5Element
	{
	public function __construct($type)
		{
		parent::__construct($type);
		}

	/**
	 * Adds a ListItem to the list
	 *
	 * @param ListItem $item to add to the list
	 *
	 * @return HTMLList
	 */
	public function addItem(ListItem $item)
		{
		$this->add($item);

		return $this;
		}
	}
