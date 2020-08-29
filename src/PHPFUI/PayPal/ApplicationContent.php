<?php

namespace PHPFUI\PayPal;

class ApplicationContent extends Base
	{
	protected static $validFields = [
		'brand_name' => 'string',
		'locale' => 'string',
		'landing_page' => ['LOGIN', 'BILLING', 'NO_PREFERENCE'],
		'shipping_preferences' => ['GET_FROM_FILE', 'NO_SHIPPING', 'SET_PROVIDED_ADDRESS'],
		'user_action' => ['CONTINUE', 'PAY_NOW'],
		'payment_method' => '',
		'return_url' => 'string',
		'cancel_url' => 'string',
		];

	public function __construct()
		{
		parent::__construct();
		}

	}
