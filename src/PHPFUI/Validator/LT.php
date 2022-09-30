<?php

namespace PHPFUI\Validator;

class LT extends \PHPFUI\Validator
	{
	public function __construct()
		{
		$className = \str_replace('\\', '', self::class);
		parent::__construct($className);
		$this->setJavaScript($this->getJavaScriptTemplate('to<from'));
		}
	}
