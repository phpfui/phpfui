<?php

namespace PHPFUI\PayPal;

/**
 * @property string $given_name
 * @property string $surname
 * @property string $full_name
 */
class Name extends \PHPFUI\PayPal\Base
	{
	/** @var array<string, string> */
	protected static array $validFields = [
		'given_name' => 'string',
		'surname' => 'string',
		'full_name' => 'string',
	];
	}
