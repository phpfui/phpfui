<?php

namespace PHPFUI\PayPal;

class ApplicationContext extends Base
	{
	protected static $validFields = [
		'brand_name' => 'string',
		'locale' => 'string',
		'landing_page' => ['LOGIN', 'BILLING', 'NO_PREFERENCE'],
		'shipping_preference' => ['GET_FROM_FILE', 'NO_SHIPPING', 'SET_PROVIDED_ADDRESS'],
		'user_action' => ['CONTINUE', 'PAY_NOW', 'SUBSCRIBE_NOW'],
		'payment_method' => PaymentMethod::class,
		'return_url' => 'string',
		'cancel_url' => 'string',
		];
	}
