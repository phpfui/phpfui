<?php

namespace PHPFUI;

/**
 * Simple SplitButton wrapper
 */
class SplitButton extends Button
	{

	private $items = [];
	private $menu;
	private $started = false;

	/**
	 * Construct a SplitButton
	 */
	public function __construct(string $text, string $link)
		{
		HTML5Element::__construct('div');
		$this->addClass('button-group');
		$this->add(new Button($text, $link));
		$this->menu = new Menu();
		}

	public function addMenuItem(MenuItem $item) : SplitButton
		{
		$this->menu->addMenuItem($item);

		return $this;
		}

	public function sort() : SplitButton
		{
		$this->menu->sort();

		return $this;
		}

	protected function getStart() : string
		{
		if (! $this->started)
			{
			$this->started = true;
			$arrow = new HTML5Element('a');
			$arrow->addClass('dropdown');
			$arrow->addClass('button');
			$arrow->addClass('arrow-only');
			$arrow->add('<span class="show-for-sr">Show menu</span>');

			$dropDown = new DropDown($arrow, $this->menu);
			$dropDown->setPosition('bottom')->setAlignment('right');

			$this->add($dropDown);
			}

		return HTML5Element::getStart();
		}

	}
