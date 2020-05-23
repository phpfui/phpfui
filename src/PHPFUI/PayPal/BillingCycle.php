<?php

namespace PHPFUI\PayPal;

class BillingCycle extends Base
	{
	protected static $validFields = [
		'pricing_scheme' => PricingScheme::class,
		'frequency' => Frequency::class,
		'tenure_type' => ['REGULAR', 'TRIAL'],
		'sequence' => 'integer',
		'total_cycles' => 'integer',
		];
	}
