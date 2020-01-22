<?php

namespace PHPFUI\Input;

/**
 * Radio Button group that implements Countable
 */
class RadioGroup extends Input implements \Countable
	{
	protected $buttons = [];
	protected $separateRows = false;

	/**
	 * Construct a Radio Button Group
	 *
	 * @param string $name of the button
	 * @param string $label optional
	 * @param ?string $value initial value
	 */
	public function __construct(string $name, string $label = '', ?string $value = null)
		{
		parent::__construct('radio', $name, $label, $value);
		}

	/**
	 * Add a optional button
	 *
	 * @param string $label for the button
	 * @param string $value for the button returned on post
	 * @param bool $disabled default false
	 */
	public function addButton($label, $value = null, $disabled = false) : RadioGroup
		{
		if (null === $value)
			{
			$value = $label;
			}

		$this->buttons[] = ['label'    => $label,
												'value'    => $value,
												'disabled' => $disabled ? 'disabled' : '',];

		return $this;
		}

	/**
	 * Return number of buttons so far
	 *
	 */
	public function count() : int
		{
		return count($this->buttons);
		}

	/**
	 * Set if each radio button should be on a separate row
	 *
	 * @param bool $sep default true
	 */
	public function setSeparateRows($sep = true) : RadioGroup
		{
		$this->separateRows = $sep;

		return $this;
		}

	protected function getStart() : string
		{
		$output = new \PHPFUI\Container();

		if ($this->label)
			{
			$label = new \PHPFUI\HTML5Element('label');
			$label->add($this->getToolTip($this->label));
			$output->add($label);
			}

		$rows = new \PHPFUI\GridX();

		foreach ($this->buttons as $button)
			{
			$radio = new Radio($this->name, $button['label'], $button['value']);
			$radio->setChecked($button['value'] == $this->value);
			$radio->setDisabled($button['disabled']);
			$rows->add($radio);

			if ($this->separateRows)
				{
				$rows->add('<br>');
				}
			}

		$output->add($rows);

		return "{$output}";
		}
	}
