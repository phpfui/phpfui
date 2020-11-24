<?php

namespace PHPFUI\PayPal;

class Refund extends \PHPFUI\PayPal\Base
	{
	protected static $validFields = [
		'amount' => Currency::class,
		'invoice_id' => 'string',
		'note_to_payer' => 'string',
		];
	}
