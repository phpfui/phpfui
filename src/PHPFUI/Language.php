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
	public static $required = ' <small>Required</small>';

	public static $emailError = 'Must be a valid email address with @ sign and domain';

	public static $urlError = 'Valid URL required. https://www.google.com for example';

	public static $numberError = 'Numbers (0-9.) only';

	public static $selectError = 'Please select.';

	// OrderableTable
	public static $updownarrow = '&updownarrow;';

	public static $dropRowHere = 'Drop Row Here';

	// SortableTable
	public static $sortIcon = null;

	public static $sortDownIcon = null;

	public static $sortUpIcon = null;

	// Pagination
	public static $next = 'Next';

	public static $previous = 'Previous';

	public static $page = 'page';

	public static $onPage = "You're on page";

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
