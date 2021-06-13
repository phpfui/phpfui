<?php

namespace PHPFUI\Input;

/**
 * A wrapper for Select controls that is Countable
 */
class Select extends \PHPFUI\Input\Input implements \Countable
	{
	protected $labelClass = [];

	protected $options = [];

	/**
	 * Construct a Select
	 *
	 * @param string $name of the field
	 * @param string $label optional
	 */
	public function __construct(string $name, string $label = '')
		{
		// not really text input, but just need to fake out the ctor with something valid
		parent::__construct('text', $name, $label);
		}

	public function addLabelClass(string $class) : Select
		{
		$this->labelClass[] = $class;

		return $this;
		}

	/**
	 * Add an OptGroup
	 */
	public function addOptGroup(OptGroup $group) : Select
		{
		$this->options[] = $group;

		return $this;
		}

	/**
	 * Add an option
	 *
	 * @param string $label required
	 * @param string $value optional
	 * @param bool $selected default false, pass true to preselect
	 *                     this option
	 * @param bool $disabled default false
	 */
	public function addOption(string $label, ?string $value = null, bool $selected = false, bool $disabled = false) : Select
		{
		if ($value === null)
			{
			$value = $label;
			}
		$label = '' === $label || null === $label ? '&nbsp;' : \PHPFUI\TextHelper::htmlentities($label);
		$this->options[] = ['label' => $label,
			'value' => $value,
			'selected' => $selected ? ' selected' : '',
			'disabled' => $disabled ? ' disabled' : '', ];

		return $this;
		}

	/**
	 * Return the number of options added
	 */
	public function count() : int
		{
		return \count($this->options);
		}

	/**
	 * Remove all options.
	 */
	public function removeAll() : Select
		{
		$this->options = [];

		return $this;
		}

	/**
	 * Remove an option.  Returns true on success.
	 *
	 * @param string $value of selection to be removed
	 * @return bool returns true if option was removed.
	 */
	public function removeOption(string $value) : bool
		{
		foreach ($this->options as $key => $select)
			{
			if ($select['value'] == $value)
				{
				unset($this->options[$key]);

				return true;
				}
			}

		return false;
		}

	/**
	 * Select an option based on the value passed
	 *
	 * @param string $selection to be selected
	 */
	public function select($selection) : Select
		{
		foreach ($this->options as &$values)
			{
			$values['selected'] = $values['value'] == $selection ? ' selected' : '';
			}

		return $this;
		}

	protected function getStart() : string
		{
		$label = $error = '';

		if ($this->label)
			{
			$label = new \PHPFUI\HTML5Element('label');

			foreach ($this->labelClass as $class)
				{
				$label->addClass($class);
				}

			$label->addAttribute('for', $this->getId());
			$label->add($this->getToolTip($this->label));
			}

		if ($this->required)
			{
			$this->addErrorMessage(\PHPFUI\Language::$selectError);

			if ($label)
				{
				$label->add(\PHPFUI\Language::$required);
				}

			$this->addAttribute('required');
			}

		if ($this->errorMessages)
			{
			$error = new \PHPFUI\HTML5Element('span');
			$error->add(\implode('', $this->errorMessages));
			$error->addClass('form-error');
			$this->addAttribute('aria-errormessage', $error->getId());
			}

		$class = $this->getClass();
		$attributes = $this->getAttributes();

		$select = $this->label ? $label : $this;
		$id = $this->getIdAttribute();
		$select->add("<select{$id}{$class}{$attributes} name='{$this->getName()}'>");

		foreach ($this->options as $option)
			{
			if (\is_object($option))
				{
				$select->add($option);
				}
			else
				{
				$selected = $option['selected'];
				$disabled = $option['disabled'];
				$select->add("<option value='{$option['value']}'{$selected}{$disabled}>{$option['label']}</option>");
				}
			}

		$select->add('</select>');
		$select->add($error);
		$this->label = null;

		return $label;
		}
	}
