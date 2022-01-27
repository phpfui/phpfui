<?php

namespace PHPFUI\Input;

/**
 * Simple CheckBox wrapper
 */
class CheckBox extends \PHPFUI\Input\Input
	{
	protected bool $center = false;

	protected string $checked = '';

	protected \PHPFUI\HTML5Element $row;

	private bool $started = false;

	/**
	 * Construct a CheckBox
	 *
	 * @param string $name of the checkbox
	 * @param string $label for the checkbox, will have automatic
	 *               for='id' logic applied
	 * @param mixed ?$value initial value, default false
	 */
	public function __construct(string $name, string $label = '', $value = null)
		{
		parent::__construct('checkbox', $name, $label, $value);
		$this->row = new \PHPFUI\HTML5Element('div');
		$this->row->addClass('checkbox-container');
		parent::add($this->row);
		}

	public function getChecked() : bool
		{
		return (bool)$this->checked;
		}

	public function setChecked(?bool $checked = true) : CheckBox
		{
		$this->checked = $checked ? ' checked' : '';

		return $this;
		}

	protected function getEnd() : string
		{
		return "{$this->getHint()}";
		}

	protected function getStart() : string
		{
		if (! $this->started)
			{
			$this->started = true;
			$id = $this->getId();
			$this->addAttribute('onkeypress', 'return event.keyCode!=13;');
			$extra = $this->getClass() . $this->getAttributes();
			$label = new \PHPFUI\HTML5Element('label');
			$label->addClass('checkbox-container');

			if ($this->getDisabled())
				{
				$label->addClass('disabled-label');
				}

			$name = $this->name ? " name='{$this->name}'" : '';
			$label->add($this->getToolTip($this->label));
			$label->add("<input type='checkbox' id='{$id}'{$this->checked}{$name} value='{$this->value}'{$extra}><span class='checkmark'></span>");
			$this->row->add($label);
			}

		return '';
		}
	}
