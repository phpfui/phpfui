<?php

namespace PHPFUI\PayPal;

class Item extends Base
	{

	protected static $validFields = [
		'name' => 'string',
		'quantity' => 'integer',
		'description' => 'string',
		'sku' => 'string',
		'tax' => '',
		'category' => 'string',
		'unit_amount' => '',
		];

	private static $initialized = false;

	public function __construct(string $name, int $quantity, Currency $unit_amount)
		{
		if (! self::$initialized)
			{
			self::$validFields['unit_amount'] = new Currency();
			self::$validFields['tax'] = new Currency();
			self::$initialized = true;
			}
		parent::__construct();
		$this->name = $name;
		$this->quantity = $quantity;
		$this->unit_amount = $unit_amount;
		}

	}
