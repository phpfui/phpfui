<?php

namespace PHPFUI\PayPal;

/**
 * @property int $version
 * @property ?\PHPFUI\PayPal\Currency $fixed_price
 * @property string $create_time
 * @property string $update_time
 */
class PricingScheme extends \PHPFUI\PayPal\Base
	{
	/** @var array<string, string> */
	protected static array $validFields = [
		'version' => 'integer',
		'fixed_price' => \PHPFUI\PayPal\Currency::class,
		'create_time' => 'string',
		'update_time' => 'string',
	];
	}
