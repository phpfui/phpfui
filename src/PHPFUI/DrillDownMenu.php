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

	public function addSubMenu(MenuItem $item, Menu $subMenu) : static
		{
		$subMenu->deleteClass('nested');
		$subMenu->addClass('vertical');
		parent::addSubMenu($item, $subMenu);

		return $this;
		}

	public function setAnimateHeight() : static
		{
		$this->setAttribute('data-animate-height', 'true');

		return $this;
		}

	public function setAutoHeight() : static
		{
		$this->setAttribute('data-auto-height', 'true');

		return $this;
		}
	}
