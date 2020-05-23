<?php

namespace PHPFUI\PayPal;

class Currency extends Base
	{

	protected static $validFields = [
		'value' => 'double',
		'currency_code' => 'string',
		];

	public function __construct(float $value = 0.0, string $currency_code = 'USD')
		{
		$this->value = $value;
		$this->currency_code = $currency_code;
		}

	}
