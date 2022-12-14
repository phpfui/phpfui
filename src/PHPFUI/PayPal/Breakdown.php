<?php

namespace PHPFUI\PayPal;

/**
 * @property ?\PHPFUI\PayPal\Currency $discount
 * @property ?\PHPFUI\PayPal\Currency $handling
 * @property ?\PHPFUI\PayPal\Currency $insurance
 * @property ?\PHPFUI\PayPal\Currency $item_total
 * @property ?\PHPFUI\PayPal\Currency $shipping
 * @property ?\PHPFUI\PayPal\Currency $shipping_discount
 * @property ?\PHPFUI\PayPal\Currency $tax_total
 */
class Breakdown extends \PHPFUI\PayPal\Base
	{
	/** @var array<string, string> */
	protected static array $validFields = [
		'discount' => \PHPFUI\PayPal\Currency::class,
		'handling' => \PHPFUI\PayPal\Currency::class,
		'insurance' => \PHPFUI\PayPal\Currency::class,
		'item_total' => \PHPFUI\PayPal\Currency::class,
		'shipping' => \PHPFUI\PayPal\Currency::class,
		'shipping_discount' => \PHPFUI\PayPal\Currency::class,
		'tax_total' => \PHPFUI\PayPal\Currency::class,
	];
	}
