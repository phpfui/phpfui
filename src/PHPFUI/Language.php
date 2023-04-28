<?php

namespace PHPFUI;

/**
 * ## Translations
 *
 * While PHPFUI does not contain much text, there is some.  The Language class allows for localization.
 *
 * It also includes various graphics which can be easily replaced.
 */
class Language
	{
	public static string $dropRowHere = 'Drop Row Here';

	public static string $emailError = 'Must be a valid email address with @ sign and domain';

	// Pagination
	public static string $next = 'Next';

	public static string $numberError = 'Numbers (0-9.) only';

	public static string $onPage = "You're on page";

	public static string $page = 'page';

	public static string $previous = 'Prev';

	// Input
	public static string $required = ' <small>Required</small>';

	public static string $selectError = 'Please select.';

	public static ?\PHPFUI\FAIcon $sortDownIcon = null;

	// SortableTable
	public static ?\PHPFUI\FAIcon $sortIcon = null;

	public static ?\PHPFUI\FAIcon $sortUpIcon = null;

	// OrderableTable
	public static string $updownarrow = '&updownarrow;';

	public static string $urlError = 'Valid URL required. https://www.google.com for example';

	public static function getSortIcon(string $type = '') : \PHPFUI\IconBase
		{
		if ('' == $type)
			{
			if (null === static::$sortIcon)
				{
				static::$sortIcon = new \PHPFUI\FAIcon('fas', 'sort');
				}

			return static::$sortIcon;
			}

		if ('up' == $type)
			{
			if (null === static::$sortUpIcon)
				{
				static::$sortUpIcon = new \PHPFUI\FAIcon('fas', 'sort-up');
				}

			return static::$sortUpIcon;
			}

		if ('down' == $type)
			{
			if (null === static::$sortDownIcon)
				{
				static::$sortDownIcon = new \PHPFUI\FAIcon('fas', 'sort-down');
				}

			return static::$sortDownIcon;
			}

		throw new \Exception('Invalid icon type in ' . self::class);
		}
	}
