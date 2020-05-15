<?php

namespace PHPFUI\PayPal;

class Breakdown extends Base
	{
	protected static $validFields = [
		'discount' => '',
		'handling' => '',
		'insurance' => '',
		'item_total' => '',
		'shipping' => '',
		'shipping_discount' => '',
		'tax_total' => '',
		];

	private static $initialized = false;

	public function __construct()
		{
		if (! self::$initialized)
			{
			foreach (self::$validFields as $field => $value)
				{
				self::$validFields[$field] = new Currency();
				}
			self::$initialized = true;
			}
		parent::__construct();
		}

	}
