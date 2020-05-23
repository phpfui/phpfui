<?php

namespace PHPFUI\PayPal;

class PaymentMethod extends Base
	{

	protected static $validFields = [
		'payer_selected' => 'string',
		'payee_preferred' => ['UNRESTRICTED', 'IMMEDIATE_PAYMENT_REQUIRED'],
		];
	}
