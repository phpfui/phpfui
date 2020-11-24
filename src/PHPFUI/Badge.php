<?php

namespace PHPFUI;

class Badge extends \PHPFUI\HTML5Element
	{
	private $readerText = '';

	/**
	 * Make a badge.
	 *
	 * @param string $text of the badge
	 * @param string $readerText for screen reader apps (optional)
	 */
	public function __construct(string $text, string $readerText = '')
		{
		parent::__construct('span');
		$this->readerText = $readerText;
		$this->addClass('badge');
		$this->add($text);
		}

	protected function getStart() : string
		{
		if ($this->readerText)
			{
			$this->add("<span class='show-for-sr'>{$this->readerText}</span>");
			$this->readerText = '';
			}

		return parent::getStart();
		}
	}
