<?php

namespace PHPFUI;

interface SessionHandler
	{
	public function checkCSRF(string $request = '') : bool;

	public function csrf(string $quote = '') : string;

	public function csrfField() : string;

	}

