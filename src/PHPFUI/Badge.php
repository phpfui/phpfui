<?php

namespace PHPFUI;

class Badge extends HTML5Element
	{

	private $readerText = '';

	/**
	 * Make a badge.
	 *
	 * @param string $text of the badge.
	 */
	public function __construct(string $text)
		{
		parent::__construct('span');
		$this->addClass('badge');
		$this->add($text);
		}

	public function setReaderText(string $text) : Badge
		{
		$this->readerText = $text;

		return $this;
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
