<?php

namespace PHPFUI\PayPal;

class PaymentSource extends Base
	{
	protected static $validFields = [
		'card' => Card::class,
		];
	}
