<?php

namespace PHPFUI\PayPal;

class Breakdown extends \PHPFUI\PayPal\Base
	{
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
