<?php

namespace PHPFUI\PayPal;

/**
 * @property ?\PHPFUI\PayPal\Name $name
 * @property ?\PHPFUI\PayPal\Address $address
 */
class ShippingDetail extends \PHPFUI\PayPal\Base
	{
	/** @var array<string, string> */
	protected static array $validFields = [
		'name' => \PHPFUI\PayPal\Name::class,
		'address' => \PHPFUI\PayPal\Address::class,
	];
	}
