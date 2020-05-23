<?php

namespace PHPFUI\PayPal;

class Shipping extends Base
	{
	protected static $validFields = [
    'method' => 'string',
    'address' => Address::class,
		];
	}
