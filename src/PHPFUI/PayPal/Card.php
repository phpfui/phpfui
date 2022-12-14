<?php

namespace PHPFUI\PayPal;

/**
 * @property string $name
 * @property string $number
 * @property string $expiry
 * @property int $security_code
 * @property ?\PHPFUI\PayPal\AddressPortable $billing_address
 */
class Card extends \PHPFUI\PayPal\Base
	{
	/** @var array<string, string> */
	protected static array $validFields = [
		'name' => 'string',
		'number' => 'string',
		'expiry' => 'string',
		'security_code' => 'integer',
		'billing_address' => \PHPFUI\PayPal\AddressPortable::class,
	];
	}
