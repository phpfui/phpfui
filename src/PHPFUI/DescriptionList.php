<?php

namespace PHPFUI;

class DescriptionList extends HTML5Element
	{

	public function __construct()
		{
		parent::__construct('dl');
		}

	public function addItem(DescriptionItem $item) : DescriptionList
		{
		parent::add($element);
		}

	}
