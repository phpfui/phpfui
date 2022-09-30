<?php

namespace PHPFUI;

class Card extends \PHPFUI\HTML5Element
	{
	public function __construct()
		{
		parent::__construct('div');
		$this->addClass('card');
		}

	public function addDivider(string $text) : Card
		{
		return $this->addSection($text, 'divider');
		}

	public function addImage(string $text) : Card
		{
		return $this->addSection($text, 'image');
		}

	public function addSection(string $text, string $type = 'section') : static
		{
		$div = new \PHPFUI\HTML5Element('div');
		$div->addClass('card-' . $type);
		$div->add($text);
		$this->add($div);

		return $this;
		}
	}
