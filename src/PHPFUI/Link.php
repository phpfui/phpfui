<?php

namespace PHPFUI;

/**
 * Utility class to properly format various forms of links.
 */
class Link extends \PHPFUI\HTML5Element
	{
	/**
	 * Format a standard html link with proper noopener and
	 * noreferrer and target=_blank attributes.
	 *
	 * @param string $link validated for correctness
	 * @param string $text shown to user for link
	 * @param bool $validate link will be validated via FILTER_VALIDATE_URL unless this is false
	 */
	public function __construct(?string $link, object | string $text = '', bool $validate = true)
		{
		parent::__construct('a');

		if (empty($link))
			{
			$link = '#';
			}

		if (empty($text))
			{
			$text = $link;
			}

		if (\is_string($text))
			{
			// break up long urls so they wrap better
			$targets = ['.',
				'@',
				'?',
				'+',
				'!',
			];
			$replacements = [];

			foreach ($targets as $string)
				{
				$replacements[] = $string . '<wbr>';
				}

			$text = \str_replace($targets, $replacements, $text);
			}

		if ('#' == $link || ! $validate)
			{
			$this->addAttribute('href', $link);
			}
		else
			{
			if (! \str_contains($link, '//'))
				{
				$link = "https://{$link}";
				}

			if (\filter_var($link, FILTER_VALIDATE_URL))
				{
				$this->addAttribute('href', \str_replace("'", '%27', $link));
				$this->addAttribute('rel', 'noopener noreferrer');
				$this->addAttribute('target', '_blank');
				}
			}

		$this->add($text);
		}

	/**
	 * Format an email as a link
	 *
	 * @param string $email must be a valid address
	 * @param string $text to show user (like user's name)
	 * @param string $subject is optional
	 */
	public static function email(string $email, string $text = '', string $subject = '') : Link
		{
		if (empty($text))
			{
			$text = $email;
			}

		if (! empty($subject))
			{
			$subject = '?subject=' . \urlencode($subject);
			}

		$email = \filter_var($email, FILTER_VALIDATE_EMAIL) ? "mailto:{$email}{$subject}" : '#';

		return new \PHPFUI\Link($email, $text, false);
		}

	/**
	 * Format a link to the current server
	 *
	 * @param string $link validated for correctness
	 * @param string $text shown to user for link
	 */
	public static function localUrl(string $link, string $text = '') : Link
		{
		return new \PHPFUI\Link($link, $text, false);
		}

	/**
	 * Format a telephone number for mobile functionality
	 *
	 * @param ?string $number can contain formatting characters, only
	 *                         digits matter
	 * @param string $text to show user
	 */
	public static function phone(?string $number, string $text = '') : ?Link
		{
		if (empty($number))
			{
			return null;
			}

		if (empty($text))
			{
			$text = $number;
			}

		return new \PHPFUI\Link('tel:' . $number, $text, false);
		}

	/**
	 * Format a telephone number for mobile functionality
	 *
	 * @param string $number can contain formatting characters, only
	 *                         digits matter
	 * @param string $text to show user
	 */
	public static function sms(string $number = '', string $text = '') : Link
		{
		if (empty($text))
			{
			$text = $number;
			}

		return new \PHPFUI\Link('sms:' . $number, $text, false);
		}
	}
