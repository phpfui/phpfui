<?php

namespace PHPFUI\PayPal;

class Refund extends \PHPFUI\PayPal\Base
	{
	protected static array $validFields = [
		'amount' => \PHPFUI\PayPal\Currency::class,
		'invoice_id' => 'string',
		'note_to_payer' => 'string',
	];
	}
