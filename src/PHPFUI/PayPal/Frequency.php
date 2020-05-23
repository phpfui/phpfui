<?php

namespace PHPFUI\PayPal;

class Frequency extends Base
	{
	protected static $validFields = [
		'interval_unit' => ['DAY', 'WEEK', 'MONTH', 'YEAR'],
		'interval_count' => 'integer',
		];
	}
