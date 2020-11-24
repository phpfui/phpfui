<?php

namespace PHPFUI;

class TitleBar extends \PHPFUI\Bar
	{
	private $title;

	public function __construct(string $title = '')
		{
		parent::__construct('title');
		$this->title = $title;
		}

	protected function getStart() : string
		{
		if ($this->title)
			{
			$title = new HTML5Element('span');
			$title->add($this->title);
			$title->addClass('title-bar-title');
			$this->addLeft($title);
			}

		return parent::getStart();
		}
	}
