<?php

namespace PHPFUI;

class TitleBar extends \PHPFUI\Bar
	{
	public function __construct(private string $title = '')
		{
		parent::__construct('title');
		}

	protected function getStart() : string
		{
		if ($this->title)
			{
			$title = new \PHPFUI\HTML5Element('span');
			$title->add($this->title);
			$title->addClass('title-bar-title');
			$this->addLeft($title);
			}

		return parent::getStart();
		}
	}
