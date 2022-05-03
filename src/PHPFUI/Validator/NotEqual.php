<?php

namespace PHPFUI\Validator;

class NotEqual extends \PHPFUI\Validator
	{
	public function __construct()
		{
		$className = \str_replace('\\', '', __CLASS__);
		parent::__construct($className);
		$this->setJavaScript($this->getJavaScriptTemplate('to!=from'));
		}
	}
