<?php

namespace PHPFUI\Input;

/**
 * Radio Button
 */
class Radio extends \PHPFUI\Input\Input
	{
	private string $checked = '';

	/**
	 * Construct a RadioButton
	 *
	 * @param string $name of the button
	 * @param string $label optional
	 * @param ?string $value initial value
	 */
	public function __construct(string $name, string $label = '', ?string $value = '')
		{
		parent::__construct('radio', $name, $label, $value);
		$this->addClass('radio-button');
		}

	public function setChecked(?bool $checked = true) : void
		{
		$this->checked = $checked ? ' checked' : '';
		}

	public function setCheckedValue($value) : void
		{
		$this->setChecked($value == $this->value);
		}

	protected function getEnd() : string
		{
		return '</label>';
		}

	protected function getStart() : string
		{
		$id = $this->getId();
		$this->addAttribute('type', $this->type);
		$this->addAttribute('id', $id);
		$this->addAttribute('name', $this->name);
		$this->addAttribute('value', $this->value);
		$attributes = $this->getAttributes();
		$classes = $this->getClass();
		$this->add($this->getToolTip($this->label));
		$labelClass = 'radio-label';

		if ($this->getDisabled())
			{
			$labelClass .= ' disabled-label';
			}

		return "<input{$attributes}{$classes}{$this->checked}{$this->disabled}/><label for='{$id}' class='{$labelClass}'>";
		}
	}
