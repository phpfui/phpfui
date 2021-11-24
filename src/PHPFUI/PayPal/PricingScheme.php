<?php

namespace PHPFUI\PayPal;

class PricingScheme extends \PHPFUI\PayPal\Base
	{
	protected static array $validFields = [
		'version' => 'integer',
		'fixed_price' => \PHPFUI\PayPal\Currency::class,
		'create_time' => 'string',
		'update_time' => 'string',
	];
	}
