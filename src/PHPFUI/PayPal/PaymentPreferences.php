<?php

namespace PHPFUI\PayPal;

/**
 * @property bool $auto_bill_outstanding
 * @property ?\PHPFUI\PayPal\Currency $setup_fee
 * @property string $setup_fee_failure_action
 * @property int $payment_failure_threshold
 */
class PaymentPreferences extends \PHPFUI\PayPal\Base
	{
	/** @var array<string, string | array<string>> */
	protected static array $validFields = [
		'auto_bill_outstanding' => 'boolean',
		'setup_fee' => \PHPFUI\PayPal\Currency::class,
		'setup_fee_failure_action' => ['CONTINUE', 'CANCEL'],
		'payment_failure_threshold' => 'integer',
	];
	}
