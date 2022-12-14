<?php

namespace PHPFUI\PayPal;

/**
 * @property ?\PHPFUI\PayPal\Name $name
 * @property string $email_address
 * @property string $payer_id
 * @property ?\PHPFUI\PayPal\ShippingDetail $shipping_address
 * @property ?\PHPFUI\PayPal\PaymentSource $payment_source
 */
class Subscriber extends \PHPFUI\PayPal\Base
	{
	/** @var array<string, string> */
	protected static array $validFields = [
		'name' => \PHPFUI\PayPal\Name::class,
		'email_address' => 'string',
		'payer_id' => 'string',
		'shipping_address' => \PHPFUI\PayPal\ShippingDetail::class,
		'payment_source' => \PHPFUI\PayPal\PaymentSource::class,
	];
	}
