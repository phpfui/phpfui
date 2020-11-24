<?php

namespace PHPFUI\PayPal;

class Subscription extends \PHPFUI\PayPal\Base
	{
	protected static $validFields = [
		'plan_id' => 'string',
		'start_time' => 'string',
		'quantity' => 'string',
		'shipping_amount' => Currency::class,
		'subscriber' => Subscriber::class,
		'auto_renewal' => 'boolean',
		'application_context' => ApplicationContext::class,
		];
	}
