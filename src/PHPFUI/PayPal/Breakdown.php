<?php

namespace PHPFUI\PayPal;

class Breakdown extends Base
	{
	protected static $validFields = [
		'discount' => Currency::class,
		'handling' => Currency::class,
		'insurance' => Currency::class,
		'item_total' => Currency::class,
		'shipping' => Currency::class,
		'shipping_discount' => Currency::class,
		'tax_total' => Currency::class,
		];
	}
