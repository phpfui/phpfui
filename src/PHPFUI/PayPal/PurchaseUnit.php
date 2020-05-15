<?php

namespace PHPFUI\PayPal;

class PurchaseUnit extends Base
	{
	protected static $validFields = [
		'reference_id' => 'string',
		'description' => 'string',
		'custom_id' => 'string',
		'invoice_id' => 'string',
		'soft_descriptor' => 'string',
		'amount' => '',
		'shipping' => '',
		];

	private static $initialized = false;

	private $items = [];

	public function __construct()
		{
		if (! self::$initialized)
			{
			self::$validFields['amount'] = new Amount();
			self::$validFields['shipping'] = new Shipping();
			self::$initialized = true;
			}
		parent::__construct();
		}

	public function addItem(Item $item) : self
		{
		$this->items[] = $item;

		return $this;
		}

	public function getData() : array
		{
		$result = parent::getData();

		if ($this->items)
			{
			$result['items'] = [];

			foreach ($this->items as $item)
				{
				$result['items'][] = $item->getData();
				}
			}

		return $result;
		}

	}
