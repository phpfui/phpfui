<?php

namespace PHPFUI\PayPal;

class PaymentMethod extends Base
	{

	protected static $validFields = [
		'payer_selected' => 'string',
		'payee_preferred' => ['UNRESTRICTED', 'IMMEDIATE_PAYMENT_REQUIRED'],
		];

	public function __construct(float $value = 0.0, string $currency_code = 'USD')
		{
		parent::__construct();
		$this->value = $value;
		$this->currency_code = $currency_code;
		}

	}
