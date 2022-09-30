<?php

namespace PHPFUI;

/**
 * Implements Googles ReCaptcha
 *
 * Use ReCAPTCHAv2 if you need to alter Google defaults
 *
 * This creates a UI element that displays the "I am not a robot" checkbox.
 *
 * Suggested use on a page
 * ```
 * $captcha = new \PHPFUI\ReCAPTCHA($page, 'public key', 'private key');
 * $page->add($captcha);
 * ```
 * On POST
 * ```
 * if ($captcha->isValid()) proceed();
 * else print_r($captcha->getErrors());
 * ```
 */
class ReCAPTCHA extends \PHPFUI\ReCAPTCHAv2 implements \PHPFUI\Interfaces\Captcha
	{
	/**
	 * Create a Google ReCAPTCHA.  If either $publicKey or
	 * $secretKey are blank, the ReCAPTCHA will not be added to the
	 * page and validation will always return true.
	 *
	 * @param \PHPFUI\Interfaces\Page $page since we need to add JS
	 * @param string $publicKey your public key
	 * @param string $secretKey your private key
	 */
	public function __construct(\PHPFUI\Interfaces\Page $page, string $publicKey, string $secretKey)
		{
		$recaptcha = null;

		if ('' != $secretKey)
			{
			$recaptcha = new \ReCaptcha\ReCaptcha($secretKey);
			}
		parent::__construct($page, $recaptcha, $publicKey);
		}
	}
