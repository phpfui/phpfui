<?php

namespace PHPFUI\PayPal;

class Taxes extends \PHPFUI\PayPal\Base
	{
	protected static $validFields = [
		'percentage' => 'string',
		'inclusive' => 'boolean',
		];
	}
