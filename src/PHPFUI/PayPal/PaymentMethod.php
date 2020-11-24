<?php

namespace PHPFUI\PayPal;

class PaymentMethod extends \PHPFUI\PayPal\Base
	{

	protected static $validFields = [
		'payer_selected' => 'string',
		'payee_preferred' => ['UNRESTRICTED', 'IMMEDIATE_PAYMENT_REQUIRED'],
		];
	}
