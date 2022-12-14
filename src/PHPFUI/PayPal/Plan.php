<?php

namespace PHPFUI\PayPal;

/**
 * @property string $product_id
 * @property string $description
 * @property string $name
 * @property string $status
 * @property ?\PHPFUI\PayPal\PaymentPreferences $payment_preferences
 * @property ?\PHPFUI\PayPal\Taxes $taxes
 * @property bool $quantity_supported
 */
class Plan extends \PHPFUI\PayPal\Base
	{
	/** @var array<BillingCycle> */
	protected array $billing_cycles = [];

	/** @var array<string, string | array<string>> */
	protected static array $validFields = [
		'product_id' => 'string',
		'description' => 'string',
		'name' => 'string',
		'status' => ['CREATED', 'INACTIVE', 'ACTIVE'],
		'payment_preferences' => \PHPFUI\PayPal\PaymentPreferences::class,
		'taxes' => \PHPFUI\PayPal\Taxes::class,
		'quantity_supported' => 'boolean',
	];

	public function addBillingCycle(BillingCycle $billing_cycle) : static
		{
		$this->billing_cycles[] = $billing_cycle;

		return $this;
		}

	public function getData() : array
		{
		$result = parent::getData();

		if ($this->billing_cycles)
			{
			$result['billing_cycles'] = [];

			foreach ($this->billing_cycles as $billing_cycle)
				{
				$result['billing_cycles'][] = $billing_cycle->getData();
				}
			}

		return $result;
		}
	}
