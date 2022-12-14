<?php

namespace PHPFUI\PayPal;

/**
 * @property string $reference_id
 * @property string $description
 * @property string $custom_id
 * @property string $invoice_id
 * @property string $soft_descriptor
 * @property ?\PHPFUI\PayPal\Amount $amount
 * @property ?\PHPFUI\PayPal\Shipping $shipping
 */
class PurchaseUnit extends \PHPFUI\PayPal\Base
	{
	/** @var array<Item> */
	protected array $items = [];

	/** @var array<string, string> */
	protected static array $validFields = [
		'reference_id' => 'string',
		'description' => 'string',
		'custom_id' => 'string',
		'invoice_id' => 'string',
		'soft_descriptor' => 'string',
		'amount' => \PHPFUI\PayPal\Amount::class,
		'shipping' => \PHPFUI\PayPal\Shipping::class,
	];

	public function addItem(Item $item) : static
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
