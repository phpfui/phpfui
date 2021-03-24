<?php

namespace PHPFUI\Input;

/**
 * CheckBoxMenu allows you to create an array of checkboxes in a menu format.  The actual checkboxes are hidden and the user only sees the selected menu options
 *
 * An all button and a submit button are also supported and can be added at any point.
 *
 * The class can be styled with the cbmenu class (similarly to the simple menu class)
 */
class CheckBoxMenu extends \PHPFUI\Menu
	{
	private $name;

	private $className;

	private $allMenuItem = null;

	private $submitMenuItem = null;

	/**
	 * @param string $name is the name of the fields that will be posted as an array
	 */
	public function __construct(string $name)
		{
		parent::__construct();
		$this->addClass('cbmenu');
		$this->name = $name;
		$this->className = $this->getId();
		}

	/**
	 * Return the class name for the menu items.
	 */
	public function getMenuItemClass() : string
		{
		return $this->className;
		}

	/**
	 * Add a select All button.  It is appended to the previously added checkboxes.
	 */
	public function addAll(string $name = 'All') : \PHPFUI\MenuItem
		{
		$this->allMenuItem = $this->addCheckBox($name, false, '', -1);
		$this->allMenuItem->setAttribute('onclick', 'var t=$(this);t.toggleClass("is-active");var m=$(".' . $this->className . '");if(t.hasClass("is-active")){m.addClass("is-active");}else{m.removeClass("is-active");};var cb=$("li.' . $this->className . ' a input[type=checkbox]");cb.prop("checked",t.hasClass("is-active"));return false;');

		return $this->allMenuItem;
		}

	/**
	 * Add a submit button in the menu style.  It is appended to the previously added checkboxes.
	 *
	 * @param string $name of the posted field
	 */
	public function addSubmit(\PHPFUI\Form $form, string $name = 'Submit') : \PHPFUI\MenuItem
		{
		$this->submitMenuItem = new \PHPFUI\MenuItem($name, false, '#');
		$formId = $form->getId();
		$this->submitMenuItem->addAttribute('onclick', '$("#' . $formId . '").submit();return false;');
		$this->addMenuItem($this->submitMenuItem);

		return $this->submitMenuItem;
		}

	/**
	 * Add a new checkbox / MenuItem
	 *
	 * @param string $name to display to the user
	 * @param bool $active true if you want this checkbox set on initial display
	 * @param string $value to return when the checkbox is selected
	 * @param ?int $index option index for the checkbox, defaults to [] (next)
	 *
	 * @return \PHPFUI\MenuItem for further modification if needed
	 */
	public function addCheckBox(string $name, bool $active, string $value, ?int $index = null) : \PHPFUI\MenuItem
		{
		if (-1 == $index)
			{
			$hidden = new \PHPFUI\Input('checkbox', '', $value);
			}
		else
			{
			$otherCount = 0;
			if ($this->allMenuItem)
				{
				++$otherCount;
				}
			if ($this->submitMenuItem)
				{
				++$otherCount;
				}
			$hidden = new \PHPFUI\Input('checkbox', $this->name . '[' . ($index ?? \count($this) - $otherCount) . ']', $value);
			}
		$hidden->addAttribute('style', 'display:none');
		if ($active)
			{
			$hidden->addAttribute('checked');
			}
		$hiddenId = $hidden->getId();
		$menuItem = new \PHPFUI\MenuItem($name . $hidden, '#');

		$menuItem->addClass($this->className);
		$menuItem->addAttribute('onclick', 'var t=$(this);t.toggleClass("is-active");$("#' . $hiddenId . '").prop("checked",t.hasClass("is-active"));return false;');
		$menuItem->setActive($active);

		$this->addMenuItem($menuItem);

		return $menuItem;
		}

	protected function getStart() : string
		{
		if ($this->allMenuItem)
			{
			foreach ($this->menuItems as $item)
				{
				if (! $item->getActive() && $this->allMenuItem != $item && $this->submitMenuItem != $item)
					{
					return parent::getStart();
					}
				}
			$this->allMenuItem->setActive();
			}

		return parent::getStart();
		}
	}
