<?php

namespace PHPFUI\PayPal;

class Plan extends \PHPFUI\PayPal\Base
	{
	protected array $billing_cycles = [];

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
