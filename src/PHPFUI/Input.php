<?php

namespace PHPFUI;

/**
 * Generic input class with default error handling
 */
class Input extends \PHPFUI\HTML5Element
	{
	protected $disabled;

	protected $name = '';

	protected $placeholder = '';

	protected $type = '';

	protected $value = '';

	private static $validInputs = [
		'button',
		'checkbox',
		'color',
		'date',
		'datetime-local',
		'email',
		'file',
		'hidden',
		'image',
		'month',
		'number',
		'password',
		'radio',
		'range',
		'reset',
		'search',
		'submit',
		'tel',
		'text',
		'time',
		'url',
		'week',
	];

	/**
	 * Construct a raw input field
	 *
	 * @param string $type of standard html input types
	 * @param string $name of input field. Input field will be
	 *                         posted as this name.
	 * @param string $value default initial value
	 *
	 * @throws \Exception if an invalid input type or a specific class exists for an input type like Date
	 */
	public function __construct(string $type, string $name, ?string $value = '')
		{
		parent::__construct('input');
		$this->name = $name;
		$this->value = $value;
		$this->type = \strtolower($type);

		if (! \in_array($type, self::$validInputs))
			{
			throw new \Exception("{$type} is not a valid HTML input type.");
			}
		}

	/**
	 * Return true if disabled
	 */
	public function getDisabled() : bool
		{
		return null !== $this->getAttribute('disabled');
		}

	/**
	 * Returns the name of the input field
	 */
	public function getName() : string
		{
		return $this->name;
		}

	/**
	 * Returns the current placeholder
	 */
	public function getPlaceholder() : string
		{
		return $this->placeholder;
		}

	/**
	 * Returns the type of the input field
	 */
	public function getType() : string
		{
		return $this->type;
		}

	/**
	 * Return the initial value of the input field
	 */
	public function getValue() : string
		{
		return "{$this->value}";
		}

	/**
	 * Set disabled
	 */
	public function setDisabled(bool $disabled = true) : Input
		{
		if ($disabled)
			{
			$this->addAttribute('disabled');
			}
		else
			{
			$this->deleteAttribute('disabled');
			}

		return $this;
		}

	public function setPlaceholder(string $placeholder) : Input
		{
		$this->placeholder = $placeholder;

		return $this;
		}

	/**
	 * Set the initial value of the input field
	 *
	 */
	public function setValue(string $value) : Input
		{
		$this->value = $value;

		return $this;
		}

	protected function getStart() : string
		{
		if ($this->name)
			{
			$this->addAttribute('name', $this->name);
			}

		$this->addAttribute('type', $this->type);

		if (null !== $this->value)
			{
			$this->addAttribute('value', \str_replace("'", '&#39;', $this->value));
			}

		if ($this->placeholder)
			{
			$this->addAttribute('placeholder', $this->placeholder);
			}

		return parent::getStart();
		}
	}
