<?php

namespace PHPFUI\PayPal;

class Address extends \PHPFUI\PayPal\Base
	{
	protected static $validFields = [
		'address_line_1' => 'string',
		'address_line_2' => 'string',
		'admin_area_2' => 'string',
		'admin_area_1' => 'string',
		'postal_code' => 'string',
		'country_code' => 'string',
	];
	}
