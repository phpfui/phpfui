<?php

namespace PHPFUI;

class Image extends HTML5Element
	{

	public function __construct(string $path, string $alt = 'photo')
		{
		parent::__construct('img');
		$this->addAttribute('src', $path);
		$this->addAttribute('alt', $alt);
		}

	}
