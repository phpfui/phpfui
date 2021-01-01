<?php

namespace PHPFUI;

/**
 * Radio Button group that implements Countable
 */
class CheckBoxGroup extends \PHPFUI\HTML5Element implements \Countable
	{
	protected $checkboxes = [];
	protected $separateRows = false;
	protected $label;

	/**
	 * Construct a CheckBoxGroup
	 */
	public function __construct(string $label = '')
		{
		parent::__construct('div');
		$this->label = $label;
		}

	/**
	 * Add a checkbox
	 */
	public function addCheckBox(\PHPFUI\Input\CheckBox $checkBox) : CheckBoxGroup
		{
		$this->checkboxes[] = $checkBox;

		return $this;
		}

	/**
	 * Return number of checkboxes so far
	 *
	 */
	public function count() : int
		{
		return count($this->checkboxes);
		}

	/**
	 * Set if each radio button should be on a separate row
	 *
	 * @param bool $sep default true
	 */
	public function setSeparateRows($sep = true) : CheckBoxGroup
		{
		$this->separateRows = $sep;

		return $this;
		}

	protected function getEnd() : string
		{
		$label = $this->label ? '</label>' : '';

		return parent::getEnd() . $label;
		}

	protected function getStart() : string
		{
		if ($this->label)
			{
			$label = '<label>';
			$label .= $this->getToolTip($this->label);
			$this->add($label);
			}

		$rows = new \PHPFUI\GridX();

		foreach ($this->checkboxes as $cb)
			{
			$rows->add($cb);

			if ($this->separateRows)
				{
				$this->add($rows);
				$rows = new \PHPFUI\GridX();
				}
			}

		$this->add($rows);

		return parent::getStart();
		}
	}
