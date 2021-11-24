<?php

namespace PHPFUI\Input;

/**
 * A multiSelect is a Select, but allows multiple choices
 */
class MultiSelect extends \PHPFUI\Input\Select
	{
	private int $gridSize = 12;

	private int $numberColumns = 1;

	private string $selectAll = '';

	/**
	 * Construct a MultiSelect
	 *
	 * @param string $name of the field
	 * @param ?string $label for the user, default empty does not provide an enclosing box.
	 */
	public function __construct(string $name, ?string $label = '')
		{
		parent::__construct($name . '[]', $label);
		}

	/**
	 * Preselect the values
	 *
	 * @param string|array $selections what should be selected on
	 *              initialization.  If an array, then any value in
	 *              the array will be selected if it matches the
	 *              options previously set. If not an array, then
	 *              just preselect the one value.
	 */
	public function select($selections) : Select
		{
		if (! \is_array($selections))
			{
			$selections = [$selections];
			}

		foreach ($this->options as &$values)
			{
			$values['selected'] = \in_array($values['value'], $selections) ? 'selected' : '';
			}

		return $this;
		}

	/**
	 * Add a select all option
	 */
	public function selectAll(string $title = 'Select All') : MultiSelect
		{
		$this->selectAll = $title;

		return $this;
		}

	/**
	 * Set the number of columns across
	 */
	public function setColumns(int $numberColumns = 1, int $gridSize = 12) : MultiSelect
		{
		$this->gridSize = $gridSize;
		$this->numberColumns = $numberColumns;

		return $this;
		}

	protected function getStart() : string
		{
		if ($this->label)
			{
			$fieldSet = new \PHPFUI\FieldSet($this->getToolTip($this->label));
			}
		else
			{
			$fieldSet = new \PHPFUI\Container();
			}

		// Get the number of rows we will need
		// count / number of columns, truncated to int, then add one if odd number
		$rowCount = (int)($this->count() / $this->numberColumns) + (int)(($this->count() % $this->numberColumns) > 0);

		$selectAllId = '';

		if ($this->selectAll)
			{
			$selectAll = new \PHPFUI\Input\CheckBox('', "<b>{$this->selectAll}</b>", 0);
			$selectAllId = $selectAll->getId();
			$selectAll->addAttribute('onClick', '$(".' . $selectAllId . '").prop("checked",this.checked)');
			$fieldSet->add($selectAll);
			}

		$gridx = new \PHPFUI\GridX();
		$row = 0;

		foreach ($this->options as $option)
			{
			if (0 == $row)
				{
				$cell = new \PHPFUI\Cell($this->gridSize / $this->numberColumns);
				}

			$checkBox = new \PHPFUI\Input\CheckBox($this->name, $option['label'], $option['value']);

			if ($selectAllId)
				{
				$checkBox->addClass($selectAllId);
				}

			if ($option['selected'])
				{
				$checkBox->setChecked(true);
				}

			if ($option['disabled'])
				{
				$checkBox->setDisabled();
				}

			$cell->add($checkBox);

			if (++$row >= $rowCount)
				{
				$row = 0;
				$gridx->add($cell);
				}
			}

		if (0 != $row)
			{
			$gridx->add($cell);
			}

		$fieldSet->add($gridx);
		$this->label = false;

		return "{$fieldSet}";
		}
	}
