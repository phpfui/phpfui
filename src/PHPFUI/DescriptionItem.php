<?php

namespace PHPFUI;

abstract class DescriptionItem extends HTML5Element
	{

	/**
	 * Base for DescriptionTitle and DescriptionDetail
	 */
	public function __construct($type)
		{
		parent::__construct($type);
		}

	}