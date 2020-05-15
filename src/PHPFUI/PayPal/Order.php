<?php

namespace PHPFUI\PayPal;

class Order
	{

	private $application_context = null;
	private $intent = '';
	private $purchase_units = [];

	public function __construct(string $intent)
		{
		$validIntents = ['CAPTURE', 'AUTHORIZE'];

		if (! in_array($intent, $validIntents))
			{
			throw new \Exception(__METHOD__ . ': $intent must be ' . implode(' or ', $validIntents));
			}
		$this->intent = $intent;
		}

	public function addPurchaseUnit(PurchaseUnit $purchase_unit) : self
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

	public function setApplicationContent(ApplicationContent $application_context) : Order
		{
		$this->application_context = $application_context;

		return $this;
		}

	}
