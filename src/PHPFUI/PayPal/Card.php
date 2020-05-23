<?php

namespace PHPFUI\PayPal;

class Card extends Base
	{
	protected static $validFields = [
		'name' => 'string',
		'number' => 'string',
		'expiry' => 'string',
		'security_code' => 'integer',
		'billing_address' => AddressPortable::class,
		];
	}
