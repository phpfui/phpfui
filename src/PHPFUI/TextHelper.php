<?php

namespace PHPFUI;

/**
 * Various useful functions for manipulating text
 */
class TextHelper
	{

	/**
	 * Converts a PHP array to a JavaScript array that can be used
	 * directly as JavaScript (not JSON)
	 *
	 * @param array $array of php values
	 * @param string $stringQuote optional quotes to use for string.
	 *  						 Include actual quotes in your string if you
	 *  						 need specify different quotes in different
	 *  						 places.
	 * @param string $newLine Pass \n if you want human readable
	 *  						 output, appends to , in output
	 */
	public static function arrayToJS(array $array, string $stringQuote = '', string $newLine = '') : string
		{
		$normalArray = is_numeric(key($array));
		$js = $normalArray ? '[' : '{';
		$comma = '';

		foreach ($array as $key => $value)
			{
			$js .= $comma;

			if (! $normalArray)
				{ // use object notation
				if (! ctype_alpha($key[0]))
					{
					$key = "{$stringQuote}{$key}{$stringQuote}";
					}
				$js .= $key . ':';
				}
			$comma = ',' . $newLine;

			switch (gettype($value))
				{
				/** @noinspection PhpMissingBreakStatementInspection */
				case 'object':
					$value = json_decode(json_encode($value), true);
					// Intentionally fall through
				case 'array':
					$js .= self::arrayToJS($value, $stringQuote);

					break;

				case 'boolean':
					$js .= $value ? 'true' : 'false';

					break;
				/** @noinspection PhpMissingBreakStatementInspection */
				case 'string':
					$value = "{$stringQuote}{$value}{$stringQuote}";
					// Intentionally fall through
				case 'integer':
				case 'double':
					$js .= $value;

					break;

				case 'resource':
				case 'NULL':
				case 'unknown type':
					$js .= 'null';
				}
			}

		return $js . ($normalArray ? ']' : '}');
		}

	/**
	 * Shorthand to encode a string in UTF-8
	 *
	 * @param ?string $string to encode
	 */
	public static function htmlentities(?string $string) : string
		{
		return htmlentities($string, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8', false);
		}

	/**
	 * Decode hmtl entities
	 *
	 * @param ?string $string to decode
	 */
	public static function unhtmlentities(?string $string) : string
		{
		return htmlspecialchars_decode($string, ENT_QUOTES | ENT_HTML5);
		}
	}
