<?php

namespace PHPFUI;

class Badge extends \PHPFUI\HTML5Element
	{
	/**
	 * Make a badge.
	 *
	 * @param string $text of the badge
	 * @param string $readerText for screen reader apps (optional)
	 */
	public function __construct(string $text, private string $readerText = '')
		{
		parent::__construct('span');
		$this->addClass('badge');
		$this->add($text);
		}

	protected function getStart() : string
		{
		$text = $this->readerText ? "<span class='show-for-sr'>{$this->readerText}</span>" : '';

		return $text . parent::getStart();
		}
	}
