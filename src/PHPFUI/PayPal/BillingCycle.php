<?php

namespace PHPFUI\PayPal;

class BillingCycle extends \PHPFUI\PayPal\Base
	{
	protected static array $validFields = [
		'pricing_scheme' => \PHPFUI\PayPal\PricingScheme::class,
		'frequency' => \PHPFUI\PayPal\Frequency::class,
		'tenure_type' => ['REGULAR', 'TRIAL'],
		'sequence' => 'integer',
		'total_cycles' => 'integer',
	];
	}
