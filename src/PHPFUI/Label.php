<?php

namespace PHPFUI;

class Label extends HTML5Element
	{

	public function __construct(string $text)
		{
		parent::__construct('span');
		$this->addClass('label');
		$this->add($text);
		}

	}
