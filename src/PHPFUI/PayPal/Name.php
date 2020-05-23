<?php

namespace PHPFUI\PayPal;

class Name extends Base
	{
	protected static $validFields = [
		'given_name' => 'string',
		'surname' => 'string',
		'full_name' => 'string',
		];
	}
