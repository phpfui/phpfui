<?php

namespace PHPFUI\Input;

/**
 * Use a switch instead of a radio button
 */
class SwitchRadio extends \PHPFUI\HTML5Element
	{
	protected \PHPFUI\HTML5Element $input;

	private string $active = '';

	private string $inactive = '';

	private bool $started = false;

	private string $title = '';

	public function __construct(string $name, $value = 0, string $title = '', string $type = 'radio')
		{
		parent::__construct('div');
		$this->title = $title;
		$this->addClass('switch');
		$this->input = new \PHPFUI\HTML5Element('input');
		$this->input->addAttribute('type', $type);
		$this->input->addAttribute('name', $name);
		$this->input->addClass('switch-input');
		$this->input->setAttribute('value', $value);
		}

	/**
	 * Display this label when active
	 */
	public function setActiveLabel(string $label) : SwitchRadio
		{
		$this->active = $label;

		return $this;
		}

	public function setChecked(bool $checked = true) : SwitchRadio
		{
		if ($checked)
			{
			$this->input->setAttribute('checked');
			}
		else
			{
			$this->input->deleteAttribute('checked');
			}

		return $this;
		}

	/**
	 * Display this label when not active
	 */
	public function setInactiveLabel(string $label) : SwitchRadio
		{
		$this->inactive = $label;

		return $this;
		}

	protected function getStart() : string
		{
		if (! $this->started)
			{
			$this->started = true;
			$this->add($this->input);
			$label = new \PHPFUI\HTML5Element('label');
			$label->addClass('switch-paddle');
			$label->addAttribute('for', $this->input->getId());
			$label->add("<span class='show-for-sr'>{$this->title}</span>");

			if ($this->active)
				{
				$label->add("<span class='switch-active' aria-hidden='true'>{$this->active}</span>");
				}

			if ($this->active)
				{
				$label->add("<span class='switch-inactive' aria-hidden='true'>{$this->inactive}</span>");
				}

			$this->add($label);
			}

		return parent::getStart();
		}
	}
