<?php

namespace PHPFUI;

class RadioTableCell extends \PHPFUI\HTML5Element
	{
	private string $disabled = '';

	private string $offBackgroundColor = 'lightgray';

	private string $offColor = 'white';

	private string $onBackgroundColor = 'white';

	private string $onColor = 'black';

	private ?\PHPFUI\RadioTable $parent = null;

	private ?\PHPFUI\HTML5Element $radioButton = null;

	public function __construct(private string $name, private ?string $value = '')
		{
		parent::__construct('label');
		}

	public function getDisabled() : bool
		{
		return ! empty($this->disabled);
		}

	public function getName() : string
		{
		return $this->name;
		}

	public function getRadioButton() : \PHPFUI\HTML5Element
		{
		if ($this->radioButton)
			{
			return $this->radioButton;
			}

		if (! $this->parent)
			{
			throw new \Exception('No parent set for ' . self::class);
			}

		$value = $this->value;

		if ('' === $value)
			{
			$value = $this->name;
			}

		$this->radioButton = new \PHPFUI\HTML5Element('input');
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
	public function setDisabled(bool $disabled = true) : static
		{
		$this->disabled = $disabled ? 'disabled' : '';

		return $this;
		}

	public function setOffColor(string $text = 'white', string $background = 'lightgray') : static
		{
		$this->offColor = $text;
		$this->offBackgroundColor = $background;

		return $this;
		}

	public function setOnColor(string $text = 'black', string $background = 'white') : static
		{
		$this->onColor = $text;
		$this->onBackgroundColor = $background;

		return $this;
		}

	public function setParent(\PHPFUI\RadioTable $parent) : static
		{
		$this->parent = $parent;

		return $this;
		}

	protected function getStart() : string
		{
		if (! $this->parent)
			{
			throw new \Exception('No parent set for ' . self::class);
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
		$this->setAttribute('for', $radioButton->getId());
		$this->add($radioButton);
		$name = new \PHPFUI\HTML5Element('strong');
		$name->add($this->name);
		$this->add($name);

		return parent::getStart();
		}
	}
