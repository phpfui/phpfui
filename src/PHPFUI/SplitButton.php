<?php

namespace PHPFUI;

/**
 * Simple SplitButton wrapper
 */
class SplitButton extends \PHPFUI\Button
	{
	private \PHPFUI\Menu $menu;

	private bool $started = false;

	public function __construct(string $text, string $link)
		{
		\PHPFUI\HTML5Element::__construct('div');
		$this->addClass('button-group');
		$this->add(new \PHPFUI\Button($text, $link));
		$this->menu = new \PHPFUI\Menu();
		}

	public function addLink(string $link, string $name) : SplitButton
		{
		return $this->addMenuItem(new \PHPFUI\MenuItem($name, $link));
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
			$dropDown = new \PHPFUI\DropDownButton('');
			$dropDown->addClass('arrow-only');

			foreach ($this->menu->getMenuItems() as $item)
				{
				$dropDown->addMenuItem($item);
				}

			$this->add($dropDown);
			}

		return \PHPFUI\HTML5Element::getStart();
		}
	}
