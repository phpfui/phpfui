<?php

namespace PHPFUI;

/**
 * Radio Button group that implements Countable
 */
class CheckBoxGroup extends \PHPFUI\HTML5Element implements \Countable
	{
	protected array $checkboxes = [];

	protected bool $separateRows = false;

	protected string $label;

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
		return \count($this->checkboxes);
		}

	/**
	 * Set if each radio button should be on a separate row
	 *
	 * @param bool $sep default true
	 */
	public function setSeparateRows(bool $sep = true) : CheckBoxGroup
		{
		$this->separateRows = $sep;

		return $this;
		}

	protected function getEnd() : string
		{
		return ($this->label ? '</fieldset>' : '') . parent::getEnd();
		}

	protected function getStart() : string
		{
		if ($this->label)
			{
			$this->add('<fieldset>');
			$legend = new \PHPFUI\HTML5Element('legend');
			$legend->add($this->getToolTip($this->label));
			$this->add($legend);
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
