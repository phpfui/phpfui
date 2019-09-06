<?php

namespace PHPFUI;

class Callout extends HTML5Element
	{

	public function __construct(string $type = '')
		{
		parent::__construct('div');
		$this->addClass('callout');

		if ($type)
			{
			$this->addClass($type);
			}
		}

	}
