<?php

namespace Fixtures;

class Missing extends \PHPFUI\Page implements \PHPFUI\Interfaces\NanoClass
	{
	public function __construct(\PHPFUI\Interfaces\NanoController $controller)
		{
		parent::__construct();
		$this->add(new \PHPFUI\Header($controller->getUri() . ' was not found on this server.'));
		}
	}
