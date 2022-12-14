<?php

namespace PHPFUI\PayPal;

/**
 * @property string $plan_id
 * @property string $start_time
 * @property string $quantity
 * @property ?\PHPFUI\PayPal\Currency $shipping_amount
 * @property ?\PHPFUI\PayPal\Subscriber $subscriber
 * @property bool $auto_renewal
 * @property ?\PHPFUI\PayPal\ApplicationContext $application_context
 */
class Subscription extends \PHPFUI\PayPal\Base
	{
	/** @var array<string, string> */
	protected static array $validFields = [
		'plan_id' => 'string',
		'start_time' => 'string',
		'quantity' => 'string',
		'shipping_amount' => \PHPFUI\PayPal\Currency::class,
		'subscriber' => \PHPFUI\PayPal\Subscriber::class,
		'auto_renewal' => 'boolean',
		'application_context' => \PHPFUI\PayPal\ApplicationContext::class,
	];
	}
