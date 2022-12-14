<?php

namespace PHPFUI\PayPal;

/**
 * @property float $value
 * @property string $currency_code
 */
class Currency extends \PHPFUI\PayPal\Base
	{
	/** @var array<string, string> */
	protected static array $validFields = [
		'value' => 'double',
		'currency_code' => 'string',
	];

	public function __construct(float $value = 0.0, string $currency_code = 'USD')
		{
		parent::__construct();
		$this->value = $value;
		$this->currency_code = $currency_code;
		}
	}
