<?php

namespace PHPFUI\PayPal;

/**
 * @property ?\PHPFUI\PayPal\PricingScheme $pricing_scheme
 * @property ?\PHPFUI\PayPal\Frequency $frequency
 * @property string $tenure_type
 * @property int $sequence
 * @property int $total_cycles
 */
class BillingCycle extends \PHPFUI\PayPal\Base
	{
	/** @var array<string, string | array<string>> */
	protected static array $validFields = [
		'pricing_scheme' => \PHPFUI\PayPal\PricingScheme::class,
		'frequency' => \PHPFUI\PayPal\Frequency::class,
		'tenure_type' => ['REGULAR', 'TRIAL'],
		'sequence' => 'integer',
		'total_cycles' => 'integer',
	];
	}
