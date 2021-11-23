<?php

namespace PHPFUI\PayPal;

class ShippingDetail extends \PHPFUI\PayPal\Base
	{
	protected static array $validFields = [
		'name' => Name::class,
		'address' => Address::class,
	];
	}
