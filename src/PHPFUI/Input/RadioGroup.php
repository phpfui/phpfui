<?php

namespace PHPFUI\Input;

/**
 * Radio Button group that implements Countable
 */
class RadioGroup extends \PHPFUI\Input\Input implements \Countable
	{
	/** @var array<array<string, string | bool>> */
	protected array $buttons = [];

	protected bool $separateRows = false;

	/**
	 * Construct a Radio Button Group
	 *
	 * @param string $name of the button
	 * @param string $label optional
	 * @param ?string $value initial value
	 */
	public function __construct(string $name, string $label = '', ?string $value = null)
		{
		parent::__construct('radio', $name, $label, (string)$value);
		}

	/**
	 * Add a optional button
	 *
	 * @param string $label for the button
	 * @param string $value for the button returned on post
	 * @param bool $disabled default false
	 */
	public function addButton(string $label, ?string $value = null, bool $disabled = false) : static
		{
		if (null === $value)
			{
			$value = $label;
			}

		$this->buttons[] = ['label' => $label,
			'value' => (string)$value,
			'disabled' => $disabled];

		return $this;
		}

	/**
	 * Return number of buttons so far
	 *
	 */
	public function count() : int
		{
		return \count($this->buttons);
		}

	/**
	 * Set if each radio button should be on a separate row
	 *
	 * @param bool $sep default true
	 */
	public function setSeparateRows(bool $sep = true) : static
		{
		$this->separateRows = $sep;

		return $this;
		}

	protected function getEnd() : string
		{
		$label = $this->label ? '</fieldset>' : '';

		return $label . $this->getHint();
		}

	protected function getStart() : string
		{
		$output = new \PHPFUI\Container();

		if ($this->label)
			{
			$output->add('<fieldset>');
			$legend = new \PHPFUI\HTML5Element('legend');
			$legend->add($this->getToolTip($this->label));
			$output->add($legend);
			}

		$rows = new \PHPFUI\GridX();

		foreach ($this->buttons as $button)
			{
			$radio = new \PHPFUI\Input\Radio($this->name, $button['label'], $button['value']);

			if ($this->required)
				{
				$radio->setRequired();
				}
			$radio->setChecked($button['value'] == $this->value);
			$radio->setDisabled($button['disabled']);
			$rows->add($radio);

			if ($this->separateRows)
				{
				$output->add($rows);
				$rows = new \PHPFUI\GridX();
				}
			}

		$output->add($rows);

		return (string)$output;
		}
	}
