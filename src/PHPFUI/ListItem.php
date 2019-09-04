<?php

namespace PHPFUI;

class ListItem extends HTML5Element
	{

	/**
	 * Simple wrapper for a ListItem <li>
	 *
	 * @param mixed $content of the ListItem
	 */
	public function __construct($content = '')
		{
		parent::__construct('li');
		$this->add($content);
		}

	}
