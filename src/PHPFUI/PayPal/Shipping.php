<?php

namespace PHPFUI\PayPal;

class Shipping extends \PHPFUI\PayPal\Base
	{
	protected static array $validFields = [
		'method' => 'string',
		'address' => \PHPFUI\PayPal\Address::class,
	];
	}
