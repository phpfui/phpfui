<?php

namespace PHPFUI\PayPal;

class PricingScheme extends \PHPFUI\PayPal\Base
	{
	protected static $validFields = [
		'version' => 'integer',
		'fixed_price' => Currency::class,
		'create_time' => 'string',
		'update_time' => 'string',
		];
	}
