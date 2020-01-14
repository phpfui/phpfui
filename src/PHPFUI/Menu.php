<?php

namespace PHPFUI;

class Menu extends HTML5Element
	{
	protected $menuItems = [];
	protected $sorted = false;
	private $started = false;

	private $type = '';

	public function __construct()
		{
		parent::__construct('ul');
		$this->addClass('menu');
		}

	public function addMenuItem(MenuItem $item) : Menu
		{
		$this->menuItems[$item->getName()] = $item;

		return $this;
		}

	public function addSubMenu(MenuItem $item, Menu $subMenu) : Menu
		{
		$subMenu->addClass('nested');
		$this->menuItems[$item->getName()] = $subMenu;

		return $this;
		}

	/**
	 * Number of object in this object.  Does not count sub objects.
	 */
	public function count() : int
		{
		return count($this->menuItems);
		}

	public function getActive() : bool
		{
		foreach ($this->menuItems as $menuItem)
			{
			if ($menuItem->getActive())
				{
				return true;
				}
			}

		return false;
		}

	public function getMenuItems() : array
		{
		return $this->menuItems;
		}

	public function getName()
		{
		return 'Menu';
		}

	/**
	 * Set the active MenuItem by link
	 *
	 * @return bool true if an active link was set
	 */
	public function setActiveLink(string $link) : bool
		{
		foreach ($this->menuItems as &$menuItem)
			{
			if (false !== strpos($link, $menuItem->getLink()))
				{
				$menuItem->setActive();

				return true;
				}
			}

		return false;
		}

	/**
	 * Set the active MenuItem by name
	 *
	 * @return bool true if an active name was set
	 */
	public function setActiveName(string $name) : bool
		{
		foreach ($this->menuItems as &$menuItem)
			{
			if ($menuItem->getName() == $name)
				{
				$menuItem->setActive();

				return true;
				}
			}

		return false;
		}

	public function setIconAlignment(string $type) : Menu
		{
		$types = ['top',
							'right',
							'bottom',
							'left'];

		if (! in_array($type, $types))
			{
			throw new Exception(__METHOD__ . ' Error: Icon type {$type} should be one of ' . implode($types));
			}

		$this->addClass('icons');
		$this->addClass('icon-' . $type);
		$this->type = $type;

		return $this;
		}

	public function sort() : Menu
		{
		$this->sorted = true;

		return $this;
		}

	protected function getStart() : string
		{
		if (! $this->started)
			{
			$this->started = true;
			$somethingActive = false;

			if ($this->sorted)
				{
				ksort($this->menuItems);
				}

			foreach ($this->menuItems as $label => $item)
				{
				if ($item instanceof MenuItem)
					{
					$somethingActive |= $item->getActive();

					if ($this->type)
						{
						$item->setAlignment($this->type);
						}

					$this->add($item);
					}
				else
					{
					$menuItem = new MenuItem($label, '#');
					$somethingActive |= $item->getActive();
					$menuItem->setActive($item->getActive());
					$menuItem->add($item);
					$this->add($menuItem);
					}
				}

			if ($somethingActive)
				{
				$this->addClass('is-active');
				}
			}

		return parent::getStart();
		}
	}
