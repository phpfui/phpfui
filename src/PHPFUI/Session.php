<?php

namespace PHPFUI;

/**
 * PHPFUI requires one session variable to validate requests for
 * a CSRF attach.  The Session class wraps the details for the
 * library.
 *
 * PHPFUI also provides basic flash support for subsequent requests in the same session.
 *
 * ### Usage
 *
 * ```
 * \PHPFUI\Session::setFlash('error', 'That was nasty!');
 * ```
 *
 * Next request:
 *
 * ```
 * \PHPFUI\Session::cycleFlash();
 * $flash = \PHPFUI\Session::getflash('error');
 * if ($flash)
 *   {
 *   $callout = new \PHPFUI\Callout('alert');
 *   $callout->add($flash);
 *   }
 * ```
 */
class Session
	{
	public const DEBUG_HTML = 1;

	public const DEBUG_JAVASCRIPT = 2;

	/** @var array<string, array<string>> */
	private static array $flash = [];

	private static ?\PHPFUI\SessionHandler $handler = null;

	public static function checkCSRF(string $request = '') : bool
		{
		return self::getHandler()->checkCSRF($request);
		}

	public static function csrf(string $quote = '') : string
		{
		return self::getHandler()->csrf($quote);
		}

	public static function csrfField() : string
		{
		return self::getHandler()->csrfField();
		}

	/**
	 * Loads the flash from the previous page and removes it for the next
	 */
	public static function cycleFlash() : void
		{
		if ($_SESSION['flash'] ?? false)
			{
			self::$flash = $_SESSION['flash'];
			unset($_SESSION['flash']);
			}
		}

	/**
	 * Return the flash for the key provided
	 */
	public static function getFlash(string $key = '') : mixed
		{
		if ($key)
			{
			return \json_decode(self::$flash[$key] ?? '', true, 512);
			}

		return '';
		}

	/**
	 * Set a flash for the next request. You can sent multiple flashes by specifying different keys
	 *
	 * @param mixed $value can by any type that can be converted to json and stored in a session. Leave empty to delete.
	 */
	public static function setFlash(string $key, mixed $value = '') : void
		{
		if ($value)
			{
			$_SESSION['flash'][$key] = \json_encode($value);
			}
		else
			{
			unset($_SESSION['flash'][$key]);
			}
		}

	/**
	 * Set the session handler if you are not using the default
	 */
	public static function setHandler(\PHPFUI\SessionHandler $handler) : void
		{
		self::$handler = $handler;
		}

	/**
	 * Get the current handler
	 */
	private static function getHandler() : \PHPFUI\SessionHandler
		{
		if (! self::$handler)
			{
			self::$handler = new \PHPFUI\DefaultSessionHandler();
			}

		return self::$handler;
		}
	}
