<?php

namespace PHPFUI;

/**
 * A simple math problem captcha for low traffic sites. Often Google ReCAPTCHA has issues and lets spammers through (and they want to sell you Google ReCAPTCHA hacking service to deliver your message to millions of sites for not much money). This is not a sophisticated captcha involving a hard to solve image, but a simple addition to Google ReCAPTCHA for automated bots that are not wise to two captchas on a page.
 *
 * Works the same way as ReCAPTCHA, just a different contructor.  You really only need to pass the Page.
 */
class MathCaptcha extends \PHPFUI\MultiColumn implements \PHPFUI\Interfaces\Captcha
	{
	private string $fieldName = 'mathAnswer';

	/** @var array<string, string> */
	private array $operators = ['plus' => '+', 'minus' => '-', 'times' => '*'];

	public function __construct(\PHPFUI\Interfaces\Page $page, int $limit = 10, string $fieldName = '')
		{
		parent::__construct();
		$this->addClass('clearfix');

		if ($fieldName)
			{
			$this->fieldName = $fieldName;
			}
		$container = new \PHPFUI\Container();
		$answers = [];
		$answer = -999;

		for ($i = 0; $i < 10; ++$i)
			{
			$operator = \random_int(0, 2);
			$type = \random_int(0, 1);
			$first = \random_int(1, $limit);
			$second = \random_int(1, $limit);

			if ($first < $second)
				{
				$temp = $first;
				$first = $second;
				$second = $temp;
				}

			\reset($this->operators);

			for ($j = 0; $j < $operator; ++$j)
				{
				\next($this->operators);
				}

			switch (\current($this->operators))
				{
				case '+':
					$answer = $first + $second;

					break;

				case '-':
					$answer = $first - $second;

					break;

				case '*':
					$answer = $first * $second;

					break;
				}

			$op = $type ? \current($this->operators) : \key($this->operators);

			$message = new \PHPFUI\HTML5Element(\random_int(0, 1) ? 'strong' : 'b');
			$message->add("Please Solve: {$first} {$op} {$second} = ");
			$message->addClass('float-right hide');
			$answers[$message->getId()] = $answer;
			$container->add((string)$message);
			}
		$this->add($container);

		$oneToShow = \random_int(0, 9);

		for ($i = 0; $i < $oneToShow; ++$i)
			{
			\next($answers);
			}
		$page->addJavaScript('$("#' . \key($answers) . '").toggleClass("hide")');
		\PHPFUI\Session::setFlash($this->fieldName, \current($answers));
		$answerInput = new \PHPFUI\Input\Number($this->fieldName);
		$this->add($answerInput);
		$this->add('&nbsp;');
		}

	public function isValid() : bool
		{
		if (\PHPFUI\Session::checkCSRF() && isset($_POST[$this->fieldName]))
			{
			return (int)$_POST[$this->fieldName] == (int)\PHPFUI\Session::getFlash($this->fieldName);
			}

		return false;
		}
	}
