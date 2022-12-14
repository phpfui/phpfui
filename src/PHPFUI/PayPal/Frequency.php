<?php

namespace PHPFUI\PayPal;

class Frequency extends \PHPFUI\PayPal\Base
	{
	/** @var array<string, string | array<string>> */
	protected static array $validFields = [
		'interval_unit' => ['DAY', 'WEEK', 'MONTH', 'YEAR'],
		'interval_count' => 'integer',
	];
	}
