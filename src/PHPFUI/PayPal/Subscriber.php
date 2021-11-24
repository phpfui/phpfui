<?php

namespace PHPFUI\PayPal;

class Subscriber extends \PHPFUI\PayPal\Base
	{
	protected static array $validFields = [
		'name' => \PHPFUI\PayPal\Name::class,
		'email_address' => 'string',
		'payer_id' => 'string',
		'shipping_address' => \PHPFUI\PayPal\ShippingDetail::class,
		'payment_source' => \PHPFUI\PayPal\PaymentSource::class,
	];
	}
