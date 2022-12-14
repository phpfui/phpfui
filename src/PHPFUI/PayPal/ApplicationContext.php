<?php

namespace PHPFUI\PayPal;

/**
 * @property string $brand_name
 * @property string $locale
 * @property string $landing_page
 * @property string $shipping_preference
 * @property string $user_action
 * @property ?\PHPFUI\PayPal\PaymentMethod $payment_method
 * @property string $return_url
 * @property string $cancel_url
 */
class ApplicationContext extends \PHPFUI\PayPal\Base
	{
	/** @var array<string, string | array<string>> */
	protected static array $validFields = [
		'brand_name' => 'string',
		'locale' => 'string',
		'landing_page' => ['LOGIN', 'BILLING', 'NO_PREFERENCE'],
		'shipping_preference' => ['GET_FROM_FILE', 'NO_SHIPPING', 'SET_PROVIDED_ADDRESS'],
		'user_action' => ['CONTINUE', 'PAY_NOW', 'SUBSCRIBE_NOW'],
		'payment_method' => \PHPFUI\PayPal\PaymentMethod::class,
		'return_url' => 'string',
		'cancel_url' => 'string',
	];
	}
