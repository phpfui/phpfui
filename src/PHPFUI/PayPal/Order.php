<?php

namespace PHPFUI\PayPal;

/**
 * @property ?\PHPFUI\PayPal\ApplicationContext $application_context
 * @property string $intent
 */
class Order extends \PHPFUI\PayPal\Base
	{
	/** @var array<string, string | array<string>> */
	protected static array $validFields = [
		'application_context' => \PHPFUI\PayPal\ApplicationContext::class,
		'intent' => ['CAPTURE', 'AUTHORIZE'],
	];

	/** @var array<PurchaseUnit> */
	private array $purchase_units = [];

	public function __construct(string $intent)
		{
		parent::__construct();
		$this->intent = $intent;
		}

	public function addPurchaseUnit(PurchaseUnit $purchase_unit) : static
		{
		$this->purchase_units[] = $purchase_unit;

		return $this;
		}

	public function getData() : array
		{
		$result = ['intent' => $this->intent];

		if ($this->application_context)
			{
			$result['application_context'] = $this->application_context->getData();
			}

		if ($this->purchase_units)
			{
			$result['purchase_units'] = [];

			foreach ($this->purchase_units as $purchase_unit)
				{
				$result['purchase_units'][] = $purchase_unit->getData();
				}
			}

		return $result;
		}
	}
