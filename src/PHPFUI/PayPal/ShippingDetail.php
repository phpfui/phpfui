<?php

namespace PHPFUI\PayPal;

class ShippingDetail extends \PHPFUI\PayPal\Base
	{
	protected static array $validFields = [
		'name' => \PHPFUI\PayPal\Name::class,
		'address' => \PHPFUI\PayPal\Address::class,
	];
	}
