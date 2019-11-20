<?php

namespace PHPFUI;

/**
 * PHPFUI requires one session variable to validate requests for
 * a CSRF attach.  The Session class wraps the details for the
 * library.
 */
class Session
	{
	public const DEBUG_HTML = 1;
	public const DEBUG_JAVASCRIPT = 2;

	private static $handler = null;

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

	public static function setHandler(SessionHandler $handler) : void
		{
		self::$handler = $handler;
		}

	private static function getHandler() : SessionHandler
		{
		if (! self::$handler)
			{
			self::$handler = new DefaultSessionHandler();
			}

		return self::$handler;
		}
	}
