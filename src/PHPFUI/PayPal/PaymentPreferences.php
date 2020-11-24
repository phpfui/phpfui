<?php

namespace PHPFUI\PayPal;

class PaymentPreferences extends \PHPFUI\PayPal\Base
	{
	protected static $validFields = [
		'auto_bill_outstanding' => 'boolean',
		'setup_fee' => Currency::class,
		'setup_fee_failure_action' => ['CONTINUE', 'CANCEL'],
		'payment_failure_threshold' => 'integer',
		];
	}
