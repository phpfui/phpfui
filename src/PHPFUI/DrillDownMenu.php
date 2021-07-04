<?php

namespace PHPFUI;

class DrillDownMenu extends \PHPFUI\Menu
	{
	public function __construct()
		{
		parent::__construct();
		$this->addClass('vertical');
		$this->addClass('drilldown');
		$this->addAttribute('data-drilldown');
		}

	public function addSubMenu(MenuItem $item, Menu $subMenu) : Menu
		{
		$subMenu->deleteClass('nested');
		$subMenu->addClass('vertical');
		parent::addSubMenu($item, $subMenu);

		return $this;
		}

	public function setAnimateHeight() : DrillDownMenu
		{
		$this->addAttribute('data-animate-height', 'true');

		return $this;
		}

	public function setAutoHeight() : DrillDownMenu
		{
		$this->addAttribute('data-auto-height', 'true');

		return $this;
		}
	}
