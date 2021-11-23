<?php

namespace PHPFUI\PayPal;

class Name extends \PHPFUI\PayPal\Base
	{
	protected static array $validFields = [
		'given_name' => 'string',
		'surname' => 'string',
		'full_name' => 'string',
	];
	}
