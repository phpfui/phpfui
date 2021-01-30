<?php

namespace PHPFUI;

/**
 * AccordionMenu has main sections that accordion to reveal submenu sections
 */
class AccordionMenu extends \PHPFUI\Menu
	{
	private $separator = '~|~';

	private $started = false;

	public function __construct()
		{
		parent::__construct();
		$this->addClass('vertical');
		$this->addClass('accordion-menu');
		$this->addAttribute('data-accordion-menu');
		}

	public function addSubMenu(MenuItem $label, Menu $subMenu) : Menu
		{
		$subMenu->addClass('vertical');
		$subMenu->addClass('nested');

		if (empty($label->getLink()))
			{
			$label->setLink('#');
			}

		if ('#' != $label->getLink())
			{
			$this->setAttribute('data-submenu-toggle', 'true');
			}

		$this->menuItems[$label->getName() . $this->separator . $label->getLink()] = $subMenu;

		return $this;
		}

	protected function getStart() : string
		{
		if (! $this->started)
			{
			$this->started = true;

			if ($this->sorted)
				{
				\ksort($this->menuItems);
				}

			foreach ($this->menuItems as $label => $item)
				{
				if ($item instanceof \PHPFUI\MenuItem)
					{
					$this->add($item);
					}
				else
					{
					[$label, $link] = \explode($this->separator, $label);
					$menuItem = new MenuItem($label, $link);

					if ($item->getActive())
						{
						$item->addClass('is-active');
						$menuItem->setActive();
						}

					$menuItem->add($item);
					$this->add($menuItem);
					}
				}

			$this->menuItems = [];
			}

		return parent::getStart();
		}
	}
