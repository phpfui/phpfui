<?php

namespace PHPFUI;

abstract class SessionHandler
	{
	abstract public function checkCSRF(string $request = '') : bool;

	abstract public function csrf(string $quote = '') : string;

	abstract public function csrfField() : string;
	}

class DefaultSessionHandler extends SessionHandler
	{
	private $csrfValue = '';

	public function checkCSRF(string $request = '') : bool
		{
		if (empty($request) && isset($_REQUEST[$this->csrfField()]))
			{
			$request = $_REQUEST[$this->csrfField()];
			}

		return ! empty($request) && ! empty($_SESSION[$this->csrfField()]) && $request == $_SESSION[$this->csrfField()];
		}

	public function csrf(string $quote = '') : string
		{
		if (! isset($_SESSION[$this->csrfField()]))
			{
			if (empty($this->csrfValue))
				{
				$this->csrfValue = sha1(mt_rand());
				}

			$_SESSION[$this->csrfField()] = $this->csrfValue;
			}

		return $quote . $_SESSION[$this->csrfField()] . $quote;
		}

	public function csrfField() : string
		{
		return 'csrf';
		}
	}

/**
 * PHPFUI requires one session variable to validate requests for
 * a CSRF attach.  The Session class wraps the details for the
 * library.
 */
class Session
	{
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
