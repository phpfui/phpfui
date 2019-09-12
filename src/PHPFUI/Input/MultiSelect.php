<?php

namespace PHPFUI\Input;

/**
 * A multiSelect is a Select, but allows multiple choices
 */
class MultiSelect extends Select
	{

	private $gridSize = 12;
	private $numberColumns = 1;

	/**
	 * Construct a MultiSelect
	 *
	 * @param string $name of the field
	 * @param ?string $label for the user, default empty
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
	 *
	 * @return MultiSelect
	 */
	public function select($selections)
		{
		if (! is_array($selections))
			{
			$selections = [$selections];
			}

		foreach ($this->options as &$values)
			{
			$values['selected'] = in_array($values['value'], $selections) ? 'selected' : '';
			}

		return $this;
		}

	/**
	 *
	 * @return MultiColumn
	 */
	public function setColumns(int $numberColumns = 1, int $gridSize = 12) : MultiSelect
		{
		$this->gridSize = $gridSize;
		$this->numberColumns = $numberColumns;

		return $this;
		}

	protected function getStart() : string
		{
		$fieldSet = new \PHPFUI\FieldSet($this->getToolTip($this->label));

		// Get the number of rows we will need
		// count / number of columns, truncated to int, then add one if odd number
		$rowCount = (int)($this->count() / $this->numberColumns) + (int)(($this->count() % $this->numberColumns) > 0);

		$fieldSet = new \PHPFUI\FieldSet($this->getToolTip($this->label));
		$gridx = new \PHPFUI\GridX();
		$row = 0;

		foreach ($this->options as $index => $option)
			{
			if (0 == $row)
				{
				$cell = new \PHPFUI\Cell($this->gridSize / $this->numberColumns);
				}
			$checkBox = new CheckBox($this->name, $option['label'], $option['value'], false);

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

		return "{$fieldSet}";
		}

	}
