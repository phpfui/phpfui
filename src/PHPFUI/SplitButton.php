<?php

namespace PHPFUI;

/**
 * Simple SplitButton wrapper
 */
class SplitButton extends \PHPFUI\Button
	{
	private $menu;

	private $started = false;

	public function __construct(string $text, string $link)
		{
		HTML5Element::__construct('div');
		$this->addClass('button-group');
		$this->add(new Button($text, $link));
		$this->menu = new Menu();
		}

	public function addLink(string $link, string $name) : SplitButton
		{
		$this->maxLength = \max($this->maxLength, \strlen($name));

		return $this->addMenuItem(new MenuItem($name, $link));
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
			$dropDown = new DropDownButton('');
			$dropDown->addClass('arrow-only');

			foreach ($this->menu->getMenuItems() as $item)
				{
				$dropDown->addMenuItem($item);
				}

			$this->add($dropDown);
			}

		return HTML5Element::getStart();
		}
	}
