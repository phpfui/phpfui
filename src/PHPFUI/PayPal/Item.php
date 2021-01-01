<?php

namespace PHPFUI\PayPal;

class Item extends \PHPFUI\PayPal\Base
	{
	protected static $validFields = [
		'name' => 'string',
		'quantity' => 'integer',
		'description' => 'string',
		'sku' => 'string',
		'tax' => Currency::class,
		'category' => ['DIGITAL_GOODS', 'PHYSICAL_GOODS'],
		'unit_amount' => Currency::class,
	];

	public function __construct(string $name, int $quantity, Currency $unit_amount)
		{
		$this->name = $name;
		$this->quantity = $quantity;
		$this->unit_amount = $unit_amount;
		}
	}
