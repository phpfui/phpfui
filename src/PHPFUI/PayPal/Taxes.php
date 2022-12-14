<?php

namespace PHPFUI\PayPal;

/**
 * @property string $percentage
 * @property bool $inclusive
 */
class Taxes extends \PHPFUI\PayPal\Base
	{
	/** @var array<string, string> */
	protected static array $validFields = [
		'percentage' => 'string',
		'inclusive' => 'boolean',
	];
	}
