<?php

namespace PHPFUI\PayPal;

class Card extends \PHPFUI\PayPal\Base
	{
	protected static array $validFields = [
		'name' => 'string',
		'number' => 'string',
		'expiry' => 'string',
		'security_code' => 'integer',
		'billing_address' => \PHPFUI\PayPal\AddressPortable::class,
	];
	}
