<?php

namespace PHPFUI;

/**
 * Implements Googles ReCaptcha with dependancy injection
 *
 * This creates a UI element that displays the "I am not a robot" checkbox.
 *
 * Suggested use on a page
 * ```
 * $captcha = new \PHPFUI\ReCAPTCHA($page, ReCaptcha\ReCaptcha $recaptcha, 'public key');
 * $page->add($captcha);
 * ```
 * On POST
 * ```
 * if ($captcha->isValid()) proceed();
 * else print_r($captcha->getErrors());
 * ```
 */
class ReCAPTCHAv2 extends \PHPFUI\HTML5Element implements \PHPFUI\Interfaces\Captcha
	{
	private array $errors = [];

	private bool $isValid = false;

	/**
	 * Create a Google ReCAPTCHA.  If either $publicKey or
	 * $secretKey are blank, the ReCAPTCHA will not be added to the
	 * page and validation will always return true.
	 *
	 * @param Page $page since we need to add JS
	 * @param ?\ReCaptcha\ReCaptcha $recaptcha constructed with your private key and configured how you want
	 * @param string $publicKey your public key
	 */
	public function __construct(\PHPFUI\Interfaces\Page $page, ?\ReCaptcha\ReCaptcha $recaptcha, string $publicKey)
		{
		parent::__construct('div');

		if ($publicKey && null !== $recaptcha)
			{
			$this->addClass('g-recaptcha');
			$this->addAttribute('data-sitekey', $publicKey);
			$page->addHeadScript('https://www.google.com/recaptcha/api.js');

			if (! empty($_POST['g-recaptcha-response']))
				{
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
		else
			{
			$this->isValid = true;
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
