<?php

namespace PHPFUI;

/**
 * Implements Googles ReCaptcha V3 (but not currently working)
 *
 * There is no UI element created for this and it can not be
 * added to a page.
 *
 * Warning: This is a work in progress and not currently working.
 */
class ReCAPTCHAv3
	{
	private $errors = null;

	private $result = 0.0;

	private $threshold = 0.5;

	private $results = [];

	/**
	 * @param Form $form since we need to add things to the form
	 * @param Button $button button to protect with CAPTCHA
	 * @param string $siteKey your public key
	 * @param string $secretKey your private key
	 * @param array $post the posted data (generally $_POST)
	 */
	public function __construct(\PHPFUI\Form $form, \PHPFUI\Button $button, string $siteKey, string $secretKey, array $post)
		{
		// do nothing if keys are not set
		if (empty($siteKey) || empty($secretKey))
			{
			return;
			}

		if ($post)
			{
			\App\Tools\Logger::get()->debug($post);
			}

		if (isset($post['g-recaptcha-response']))
			{
			$captcha = $post['g-recaptcha-response'];
			$response = \file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $captcha . '&remoteip=' . $_SERVER['REMOTE_ADDR']);
			$this->results = \json_decode($response, true);

			if ($this->results['success'])
				{
				$this->result = $this->results['score'];
				}
			}

		$page = $form->getPage();
		$page->addHeadScript('https://www.google.com/recaptcha/api.js?render=' . $siteKey);
		// action is the page name
		$action = $page->getBaseURL();

		// add attributes to the passed button
		$formId = $form->getId();
		$button->addClass('g-recaptcha');
		$button->addAttribute('data-sitekey', $siteKey);
		$button->addAttribute('data-callback', 'onClick' . $formId);
		$button->addAttribute('data-action', 'submit');

		$hidden = new \PHPFUI\Input\Hidden('g-recaptcha-response');
		$hiddenId = $hidden->getId();
		$form->add($hidden);

		$js = "function onClick{$formId}(e){e.preventDefault();grecaptcha.ready(function(){grecaptcha.execute('{$siteKey}',{action:'submit'}).then(function(token){alert('execute');document.getElementById('{$hiddenId}').value=token;document.getElementById('{$formId}').submit();})})};";
		$page->addJavaScript($js);
		}

	/**
	 * Returns any errors from Google
	 */
	public function getErrors() : array
		{
		return $this->errors;
		}

	/**
	 * Returns results from Google
	 */
	public function getResults() : array
		{
		return $this->results;
		}

	/**
	 * Returns true if OK to proceed
	 */
	public function isValid() : bool
		{
		return $this->result >= $this->threshold;
		}

	/**
	 * Set a threshold that user needs to pass.  Default 0.5
	 */
	public function setThreshold(float $threshold = 0.5) : ReCAPTCHAv3
		{
		$this->threshold = $threshold;

		return $this;
		}
	}
