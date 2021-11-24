<?php

namespace PHPFUI;

/**
 * FormErrors are automatically shown if there is an error in the form.
 */
class FormError extends \PHPFUI\HTML5Element
	{
	public function __construct(string $message = 'Please correct the errors shown.')
		{
		parent::__construct('div');
		$this->addClass('alert');
		$this->addClass('callout');
		$this->addAttribute('data-abide-error');
		$this->addAttribute('aria-live', 'assertive');
		$this->addAttribute('style', 'display: none;');
		$icon = new \PHPFUI\Icon('exclamation-triangle');
		$this->add("<p>{$icon} {$message}</p>");
		}
	}
