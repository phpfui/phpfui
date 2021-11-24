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
		$normalArray = \is_numeric(\key($array));
		$js = $normalArray ? '[' : '{';
		$comma = '';

		foreach ($array as $key => $value)
			{
			$js .= $comma;

			if (! $normalArray)
				{ // use object notation
				if (! \ctype_alpha($key[0]))
					{
					$key = "{$stringQuote}{$key}{$stringQuote}";
					}
				$js .= $key . ':';
				}
			$comma = ',' . $newLine;

			switch (\gettype($value))
				{
				/** @noinspection PhpMissingBreakStatementInspection */
				case 'object':
					$value = \json_decode(\json_encode($value), true);
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
	 * Split a string into words based on capital letters. Successive capital letters are considered an appreviation and grouped together.
	 */
	public static function capitalSplit(string $key) : string
		{
		$len = \strlen($key);
		$space = $output = '';
		$lastCapitalized = false;
		$consecutiveCaps = 0;

		for ($i = 0; $i < $len; ++$i)
			{
			$char = $key[$i];

			if (0 == $i)
				{
				$char = \strtoupper($char);
				}

			if (\ctype_upper($char))
				{
				if (! $lastCapitalized)
					{
					$output .= $space;
					}
				++$consecutiveCaps;
				$space = ' ';
				$lastCapitalized = true;
				}
			elseif ($lastCapitalized)
				{
				$length = \strlen($output);

				if ($length > 1 && $consecutiveCaps > 1)
					{
					$output = \substr($output, 0, $length - 1) . ' ' . $output[$length - 1];
					}
				$consecutiveCaps = 0;
				$lastCapitalized = false;
				}
			$output .= $char;
			}

		return $output;
		}

	/**
	 * Shorthand to encode a string in UTF-8
	 *
	 * @param ?string $string to encode
	 */
	public static function htmlentities(?string $string) : string
		{
		return \htmlentities($string, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8', false);
		}

	public static function replace_unicode_escape_sequence(array $match) : string
		{
		return \mb_convert_encoding(\pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
		}

	/**
	 * Decode hmtl entities
	 *
	 * @param ?string $string to decode
	 */
	public static function unhtmlentities(?string $string) : string
		{
		return \htmlspecialchars_decode($string, ENT_QUOTES | ENT_HTML5);
		}

	public static function unicode_decode(string $str) : string
		{
		return \preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 'static::replace_unicode_escape_sequence', $str);
		}
	}
