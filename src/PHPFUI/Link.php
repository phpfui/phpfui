<?php

namespace PHPFUI;

/**
 * Utility class to properly format various forms of links.
 */
class Link extends HTML5Element
	{

	/**
	 * Format a standard html link with proper noopener and
	 * noreferrer and target=_blank attributes.
	 *
	 * @param string $link validated for correctness
	 * @param string $text shown to user for link
	 */
	public function __construct(?string $link, string $text = '', bool $validate = true)
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

		// break up long urls so they wrap better
		$targets = ['.',
								'@',
								'&',
								'?',
								'+',
								'!',
								':'];
		$replacements = [];

		foreach ($targets as $string)
			{
			$replacements[] = $string . '<wbr>';
			}

		$text = str_replace($targets, $replacements, $text);

		if ('#' == $link || ! $validate)
			{
			$this->addAttribute('href', $link);
			}
		elseif ($validate)
			{
			if (false === strpos($link, '//'))
				{
				$link = "https://{$link}";
				}

			if (filter_var($link, FILTER_VALIDATE_URL))
				{
				$this->addAttribute('href', $link);
				$this->addAttribute('rel', 'noopener noreferrer');
				$this->addAttribute('target', '_blank');
				}
			}

		$this->add($text);
		}

	/**
	 * Format an email as a link
	 *
	 * @param string @email must be a valid address
	 * @param string $text to show user (like user's name)
	 * @param string $subject is optional
	 *
	 * @return string
	 */
	public static function email($email, $text = '', $subject = '')
		{
		if (empty($text))
			{
			$text = $email;
			}

		if (! empty($subject))
			{
			$subject = '?subject=' . urlencode($subject);
			}

		if (filter_var($email, FILTER_VALIDATE_EMAIL))
			{
			$email = "mailto:{$email}{$subject}";
			}
		else
			{
			$email = '#';
			}

		return new Link($email, $text, false);
		}

	/**
	 * Format a link to the current server
	 *
	 * @param string $link validated for correctness
	 * @param string $text shown to user for link
	 *
	 * @return Link
	 */
	public static function localUrl($link, $text = '')
		{
		if (false === strpos($link, '//'))
			{
			$link = 'https://' . $_SERVER['SERVER_NAME'] . $link;
			}

		return new Link($link, $text, false);
		}

	/**
	 * Format a telephone number for mobile functionality
	 *
	 * @param string $number can contain formatting characters, only
	 *                         digits matter
	 * @param string $text to show user
	 *
	 * @return string
	 */
	public static function phone($number, $text = '')
		{
		if (empty($text))
			{
			$text = $number;
			}

		return new Link('tel:' . $number, $text, false);
		}
	}
