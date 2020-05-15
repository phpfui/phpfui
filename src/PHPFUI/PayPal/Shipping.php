<?php

namespace PHPFUI\PayPal;

class Shipping extends Base
	{
	protected static $validFields = [
    'method' => 'string',
    'address' => '',
		];

	private static $initialized = false;

	public function __construct()
		{
		if (! self::$initialized)
			{
			self::$validFields['address'] = new Address();
			self::$initialized = true;
			}
		parent::__construct();
		}

	}
