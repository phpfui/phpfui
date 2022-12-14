<?php

namespace PHPFUI\PayPal;

/**
 * @property ?\PHPFUI\PayPal\Currency $amount
 * @property string $invoice_id
 * @property string $note_to_payer
 */
class Refund extends \PHPFUI\PayPal\Base
	{
	/** @var array<string, string> */
	protected static array $validFields = [
		'amount' => \PHPFUI\PayPal\Currency::class,
		'invoice_id' => 'string',
		'note_to_payer' => 'string',
	];
	}
