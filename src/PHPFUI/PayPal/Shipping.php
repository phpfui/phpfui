<?php

namespace PHPFUI\PayPal;

/**
 * @property string $method
 * @property ?\PHPFUI\PayPal\Address $address
 */
class Shipping extends \PHPFUI\PayPal\Base
	{
	/** @var array<string, string> */
	protected static array $validFields = [
		'method' => 'string',
		'address' => \PHPFUI\PayPal\Address::class,
	];
	}
