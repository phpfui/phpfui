<?php

namespace PHPFUI\PayPal;

class PaymentSource extends \PHPFUI\PayPal\Base
	{
	protected static $validFields = [
		'card' => Card::class,
		];
	}
