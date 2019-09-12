<?php

namespace PHPFUI;

class DropDownMenu extends Menu
	{

	private $width = null;

	public function __construct()
		{
		parent::__construct();
		$this->addClass('dropdown');
		$this->addAttribute('data-dropdown-menu');
		}

	public function computeWidth() : DropDownMenu
		{
		$this->width = 0;

		return $this;
		}

	public function setWidth(int $ems) : DropDownMenu
		{
		$this->width = $ems;

		return $this;
		}

	protected function getStart() : string
		{
		if (0 === $this->width)
			{
			foreach ($this->menuItems as $label => $item)
				{
				$this->width = max($this->width, strlen($item->getName()));
				}
			$this->width = (int) ($this->width * 0.8);
			}

		if ($this->width)
			{
			$this->addAttribute('style', "max-width:{$this->width}em;");
			}

		return parent::getStart();
		}

	}
