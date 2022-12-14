<?php

namespace PHPFUI\PayPal;

/**
 * @property string $payer_selected
 * @property string $payee_preferred
 */
class PaymentMethod extends \PHPFUI\PayPal\Base
	{
	/** @var array<string, string | array<string>> */
	protected static array $validFields = [
		'payer_selected' => 'string',
		'payee_preferred' => ['UNRESTRICTED', 'IMMEDIATE_PAYMENT_REQUIRED'],
	];
	}
