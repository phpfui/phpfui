<?php

namespace PHPFUI\PayPal;

/**
 * @property string $address_line_1
 * @property string $address_line_2
 * @property string $address_line_3
 * @property string $admin_area_1
 * @property string $admin_area_2
 * @property string $admin_area_3
 * @property string $admin_area_4
 * @property string $postal_code
 * @property string $country_code
 */
class AddressPortable extends \PHPFUI\PayPal\Base
	{
	/** @var array<string, string> */
	protected static array $validFields = [
		'address_line_1' => 'string',
		'address_line_2' => 'string',
		'address_line_3' => 'string',
		'admin_area_1' => 'string',
		'admin_area_2' => 'string',
		'admin_area_3' => 'string',
		'admin_area_4' => 'string',
		'postal_code' => 'string',
		'country_code' => 'string',
	];
	}
