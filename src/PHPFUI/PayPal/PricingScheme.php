<?php

namespace PHPFUI\PayPal;

class PricingScheme extends Base
	{
	protected static $validFields = [
		'version' => 'integer',
		'fixed_price' => Currency::class,
		'create_time' => 'string',
		'update_time' => 'string',
		];
	}
