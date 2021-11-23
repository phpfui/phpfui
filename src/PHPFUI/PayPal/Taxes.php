<?php

namespace PHPFUI\PayPal;

class Taxes extends \PHPFUI\PayPal\Base
	{
	protected static array $validFields = [
		'percentage' => 'string',
		'inclusive' => 'boolean',
	];
	}
