<?php

namespace PHPFUI;

class DescriptionDetail extends \PHPFUI\DescriptionItem
	{
	/**
	 * Simple wrapper for a DescriptionTitle <dd>
	 *
	 * @param mixed $content of the DescriptionDetail
	 */
	public function __construct($content = '')
		{
		parent::__construct('dd');
		$this->add($content);
		}
	}
