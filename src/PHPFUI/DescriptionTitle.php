<?php

namespace PHPFUI;

class DescriptionTitle extends \PHPFUI\DescriptionItem
	{
	/**
	 * Simple wrapper for a DescriptionTitle <dt>
	 *
	 * @param mixed $content of the DescriptionTitle
	 */
	public function __construct(string $content = '')
		{
		parent::__construct('dt');
		$this->add($content);
		}
	}
