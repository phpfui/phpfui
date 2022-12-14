<?php

namespace PHPFUI\PayPal;

/**
 * @property ?\PHPFUI\PayPal\Card $card
 */
class PaymentSource extends \PHPFUI\PayPal\Base
	{
	/** @var array<string, string> */
	protected static array $validFields = [
		'card' => \PHPFUI\PayPal\Card::class,
	];
	}
