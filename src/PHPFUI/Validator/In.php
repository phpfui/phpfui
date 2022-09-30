<?php

namespace PHPFUI\Validator;

class In extends \PHPFUI\Validator
	{
	public function __construct()
		{
		$className = \str_replace('\\', '', self::class);
		parent::__construct($className);
		$this->setJavaScript($this->getJavaScriptTemplate('to.includes(from)'));
		}
	}
