<?php

namespace Fixtures;

class Missing extends \PHPFUI\Page implements \PHPFUI\Interfaces\NanoClass
	{

	public function __construct(\PHPFUI\NanoController $controller)
		{
		parent::__construct($controller);
		$this->add(new \PHPFUI\Header($controller->getUri() . ' was not found on this server.'));
		}

	}
