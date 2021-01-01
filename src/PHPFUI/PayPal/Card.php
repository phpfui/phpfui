<?php

namespace PHPFUI\PayPal;

class Card extends \PHPFUI\PayPal\Base
	{
	protected static $validFields = [
		'name' => 'string',
		'number' => 'string',
		'expiry' => 'string',
		'security_code' => 'integer',
		'billing_address' => AddressPortable::class,
	];
	}
