<?php

namespace Fixtures;

class Model extends \PHPFUI\HTML5Element
	{

	public function __construct(string $data)
		{
		parent::__construct('div');
		$this->add($data);
		}

	}
