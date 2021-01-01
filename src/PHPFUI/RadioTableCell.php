<?php

namespace PHPFUI;

class RadioTableCell extends \PHPFUI\HTML5Element
	{
	private $disabled = '';

	private $disabledColor = 'gray';

	private $name;

	private $offBackgroundColor = 'lightgray';

	private $offColor = 'white';

	private $onBackgroundColor = 'white';

	private $onColor = 'black';

	private $parent = null;

	private $radioButton = null;

	private $value;

	public function __construct(string $name, ?string $value = '')
		{
		parent::__construct('label');
		$this->name = $name;
		$this->value = $value;
		}

	public function getDisabled() : bool
		{
		return ! empty($this->disabled);
		}

	public function getName() : string
		{
		return $this->name;
		}

	public function getOffColor($checked)
		{
		if ($this->disabled)
			{
			return $this->disabledColor;
			}
		}

	public function getOnColor($checked)
		{
		if ($this->disabled)
			{
			return $this->disabledColor;
			}
		}

	public function getRadioButton()
		{
		if ($this->radioButton)
			{
			return $this->radioButton;
			}

		if (! $this->parent)
			{
			throw new \Exception('No parent set for ' . __CLASS__);
			}

		$value = $this->value;

		if ('' === $value)
			{
			$value = $this->name;
			}

		$this->radioButton = new HTML5Element('input');
		$this->radioButton->addAttribute('type', 'radio');
		$this->radioButton->addAttribute('value', $value);
		$this->radioButton->addAttribute('name', $this->parent->getName());
		// generate an id, will need it later
		$this->radioButton->getId();
		$style = "color:{$this->offColor};background-color:{$this->offBackgroundColor};";

		if ($value == $this->parent->getValue())
			{
			$style = "color:{$this->onColor};background-color:{$this->onBackgroundColor};";
			$this->radioButton->addAttribute('checked');
			}

		$this->addAttribute('style', $style);
		$this->radioButton->addAttribute($this->disabled);

		return $this->radioButton;
		}

	/**
	 * Set disabled
	 *
	 * @param bool $disabled default to true
	 */
	public function setDisabled(bool $disabled = true) : RadioTableCell
		{
		$this->disabled = $disabled ? 'disabled' : '';

		return $this;
		}

	public function setOffColor(string $text = 'white', string $background = 'lightgray') : RadioTableCell
		{
		$this->offColor = $text;
		$this->offBackgroundColor = $background;

		return $this;
		}

	public function setOnColor(string $text = 'black', string $background = 'white') : RadioTableCell
		{
		$this->onColor = $text;
		$this->onBackgroundColor = $background;

		return $this;
		}

	public function setParent(RadioTable $parent)
		{
		$this->parent = $parent;

		return $this;
		}

	protected function getStart() : string
		{
		if (! $this->parent)
			{
			throw new \Exception('No parent set for ' . __CLASS__);
			}

		$radioButton = $this->getRadioButton();
		$onClick = '';

		foreach ($this->parent->getButtons() as $button)
			{
			$cb = $button->getRadioButton();

			if ($cb == $radioButton)
				{
				$onClick .= 'checkRadioTable("' . $cb->getId() . '","' . $button->onColor . '","' . $button->onBackgroundColor . '");';
				}
			else
				{
				$onClick .= 'checkRadioTable("' . $cb->getId() . '","' . $button->offColor . '","' . $button->offBackgroundColor . '");';
				}
			}

		$radioButton->addAttribute('onclick', $onClick);
		$this->addClass('RadioTableButton');
		$this->addAttribute('for', $radioButton->getId());
		$this->add($radioButton);
		$name = new HTML5Element('strong');
		$name->add($this->name);
		$this->add($name);

		return parent::getStart();
		}
	}
