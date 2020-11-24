<?php

namespace PHPFUI;

/**
 * Simple wrapper for OrderedList
 */
class OrderedList extends \PHPFUI\HTMLList
	{
	public function __construct()
		{
		parent::__construct('ol');
		}
	}
