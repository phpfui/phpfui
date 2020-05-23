<?php

namespace PHPFUI\PayPal;

class Refund extends Base
	{
	protected static $validFields = [
		'amount' => Currency::class,
		'invoice_id' => 'string',
		'note_to_payer' => 'string',
		];
	}
