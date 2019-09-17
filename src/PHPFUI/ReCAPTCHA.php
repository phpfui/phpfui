<?php

namespace PHPFUI;

/**
 * Implements Googles ReCaptcha
 *
 * This creates a UI element that displays the "I am not a
 * robot" checkbox.
 *
 * Suggested use on contact form
 *
 * $captcha = new \PHPFUI\ReCAPTCHA($this->page, 'public key',
 *   'private key');
 * $page->add($captcha);
 *
 * On post
 *
 * if ($captcha->isValid()) proceed();
 * else print_r($captcha->getErrors());
 */
class ReCAPTCHA extends HTML5Element
	{
	private $errors = null;

	private $isValid = false;

	/**
	 * Constuct a ReCAPTCHA
	 *
	 * @param Page $page since we need to add JS
	 * @param string $publicKey your public key
	 * @param string $secretKey your private key
	 */
	public function __construct(Page $page, string $publicKey, string $secretKey)
		{
		parent::__construct('div');
		$this->addClass('g-recaptcha');
		$this->addAttribute('data-sitekey', $publicKey);
		$page->addHeadScript('https://www.google.com/recaptcha/api.js');

		if (! empty($_POST['g-recaptcha-response']))
			{
			$recaptcha = new \ReCaptcha\ReCaptcha($secretKey);
			$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

			if ($resp->isSuccess())
				{
				$this->isValid = true;
				}
			else
				{
				$this->errors = $resp->getErrorCodes();
				}
			}
		}

	/**
	 * Returns any errors from Google
	 */
	public function getErrors() : array
		{
		return $this->errors;
		}

	/**
	 * Returns true if OK to proceed
	 */
	public function isValid() : bool
		{
		return $this->isValid;
		}
	}
