<?php

namespace PHPFUI\PayPal;

/**
 * @property string $name
 * @property int $quantity
 * @property string $description
 * @property string $sku
 * @property ?\PHPFUI\PayPal\Currency $tax
 * @property string $category
 * @property ?\PHPFUI\PayPal\Currency $unit_amount
 */
class Item extends \PHPFUI\PayPal\Base
	{
	/** @var array<string, string | array<string>> */
	protected static array $validFields = [
		'name' => 'string',
		'quantity' => 'integer',
		'description' => 'string',
		'sku' => 'string',
		'tax' => \PHPFUI\PayPal\Currency::class,
		'category' => ['DIGITAL_GOODS', 'PHYSICAL_GOODS'],
		'unit_amount' => \PHPFUI\PayPal\Currency::class,
	];

	public function __construct(string $name, int $quantity, Currency $unit_amount)
		{
		parent::__construct();
		$this->name = $name;
		$this->quantity = $quantity;
		$this->unit_amount = $unit_amount;
		}
	}
