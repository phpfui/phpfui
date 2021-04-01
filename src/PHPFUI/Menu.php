<?php

namespace PHPFUI;

class Menu extends \PHPFUI\HTML5Element
	{
	protected $menuItems = [];

	protected $menuLabels = [];

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
		$name = $item->getName() . ':' . \count($this->menuItems);
		$this->menuItems[$name] = $item;
		$this->menuLabels[$name] = $item->getName();

		return $this;
		}

	public function addSubMenu(MenuItem $item, Menu $subMenu) : Menu
		{
		$subMenu->addClass('nested');
		$name = $item->getName() . ':' . \count($this->menuItems);
		$this->menuItems[$name] = $subMenu;
		$this->menuLabels[$name] = $item->getName();

		return $this;
		}

	/**
	 * Number of object in this object.  Does not count sub objects.
	 */
	public function count() : int
		{
		return \count($this->menuItems);
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
			if (false !== \strpos($link, $menuItem->getLink()))
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

	/**
	 * @param string $type must one of top, right, bottom, left
	 */
	public function setIconAlignment(string $type) : Menu
		{
		$types = ['top',
			'right',
			'bottom',
			'left', ];

		if (! \in_array($type, $types))
			{
			throw new Exception(__METHOD__ . ' Error: Icon type {$type} should be one of ' . \implode('', $types));
			}

		$this->addClass('icons');
		$this->addClass('icon-' . $type);
		$this->type = $type;

		return $this;
		}

	/**
	 * Sort the menu by name displayed to the user.
	 */
	public function sort() : Menu
		{
		$this->sorted = true;
		\ksort($this->menuItems);

		return $this;
		}

	protected function getStart() : string
		{
		if (! $this->started)
			{
			$this->started = true;
			$somethingActive = 0;

			if ($this->sorted)
				{
				\ksort($this->menuItems);
				}

			foreach ($this->menuItems as $label => $item)
				{
				if ($item instanceof \PHPFUI\MenuItem)
					{
					$somethingActive |= (int)$item->getActive();

					if ($this->type)
						{
						$item->setAlignment($this->type);
						}

					$this->add($item);
					}
				else
					{
					$menuItem = new MenuItem($this->menuLabels[$label], '#');
					$somethingActive |= (int)$item->getActive();
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
