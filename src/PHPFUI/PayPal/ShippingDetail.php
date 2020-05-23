<?php

namespace PHPFUI\PayPal;

class ShippingDetail extends Base
	{
	protected static $validFields = [
		'name' => Name::class,
		'address' => Address::class,
		];
	}
