<?php

namespace PHPFUI\PayPal;

class PaymentSource extends \PHPFUI\PayPal\Base
	{
	protected static array $validFields = [
		'card' => \PHPFUI\PayPal\Card::class,
	];
	}
