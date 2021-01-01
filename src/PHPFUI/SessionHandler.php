<?php

namespace PHPFUI;

/**
 * If you choose not to use the basic PHPFUI session handler, you will need to implement this interface.
 */
interface SessionHandler
	{
	/**
	 * Returns true if the CSRF token is correct
	 */
	public function checkCSRF(string $request = '') : bool;

	/**
	 * Returns the csrf token for the session.
	 *
	 * @param string $quote optional quotes you many need to easily insert in the output.
	 */
	public function csrf(string $quote = '') : string;

	/**
	 * Get the name of the csrf field
	 */
	public function csrfField() : string;
	}
