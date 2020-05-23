<?php

namespace PHPFUI\PayPal;

class Taxes extends Base
	{
	protected static $validFields = [
		'percentage' => 'string',
		'inclusive' => 'boolean',
		];
	}
