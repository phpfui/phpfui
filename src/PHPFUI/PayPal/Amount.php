<?php

namespace PHPFUI\PayPal;

class Amount extends Base
	{
	protected static $validFields = [
		'currency_code' => 'string',
		'value' => 'string',
		'breakdown' => '',
		];

	private static $initialized = false;

	public function __construct()
		{
		if (! self::$initialized)
			{
			self::$validFields['breakdown'] = new Breakdown();
			self::$initialized = true;
			}
		parent::__construct();
		}

	public function setCurrency(Currency $currency) : self
		{
		foreach ($currency->getData() as $field => $value)
			{
			$this->{$field} = $value;
			}

		return $this;
		}

	}
