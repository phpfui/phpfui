<?php

namespace PHPFUI\PayPal;

class Subscriber extends \PHPFUI\PayPal\Base
	{
	protected static $validFields = [
		'name' => Name::class,
		'email_address' => 'string',
		'payer_id' => 'string',
		'shipping_address' => ShippingDetail::class,
		'payment_source' => PaymentSource::class,
	];
	}
