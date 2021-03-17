<?php

namespace PHPFUI;

abstract class DescriptionItem extends \PHPFUI\HTML5Element
	{
	/**
	 * Base for DescriptionTitle and DescriptionDetail
	 */
	public function __construct(string $type)
		{
		parent::__construct($type);
		}
	}
