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
	// Input
	public static string $required = ' <small>Required</small>';

	public static string $emailError = 'Must be a valid email address with @ sign and domain';

	public static string $urlError = 'Valid URL required. https://www.google.com for example';

	public static string $numberError = 'Numbers (0-9.) only';

	public static string $selectError = 'Please select.';

	// OrderableTable
	public static string $updownarrow = '&updownarrow;';

	public static string $dropRowHere = 'Drop Row Here';

	// SortableTable
	public static $sortIcon = null;

	public static $sortDownIcon = null;

	public static $sortUpIcon = null;

	// Pagination
	public static string $next = 'Next';

	public static string $previous = 'Prev';

	public static string $page = 'page';

	public static string $onPage = "You're on page";

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

		throw new \Exception('Invalid icon type in ' . __CLASS__);
		}
	}
