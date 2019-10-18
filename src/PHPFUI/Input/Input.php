<?php

namespace PHPFUI\Input;

/**
 * Generic input class with default error handling
 */
abstract class Input extends \PHPFUI\Input
	{
	protected $error;
	protected $errorMessages = [];
	protected $hint;
	protected $hintText = '';
	protected $label;

	protected $required = false;
	private $started = false;

	/**
	 * Construct an input field for Abide validation and label
	 *
	 * @param string $type of standard html input types
	 * @param string $name of input field. Input field will be
	 *                         posted as this name.
	 * @param string $label optional label for use, will have
	 *               automatic for='id' logic applied
	 * @param ?string $value default initial value
	 *
	 * @throws \Exception if an invalid input type or a specific class exists for an input type like Date
	 */
	public function __construct(string $type, string $name = '', string $label = '', ?string $value = '')
		{
		parent::__construct($type, $name, $value);
		$this->label = $label;

		switch ($this->type)
			{
			case 'email':
				$this->errorMessages['Must be a valid email address with @ sign and domain'] = true;
				$this->addAttribute('pattern', $this->type);

				break;

			case 'url':
				$this->errorMessages['Valid URL required. https://www.google.com for example'] = true;
				$this->addAttribute('pattern', $this->type);

				break;

			case 'number':
				$this->errorMessages['Numbers (0-9.) only'] = true;

				break;

			case 'datetime-local':
				$this->addAttribute('pattern', 'datetime');

				break;

			case 'color':
				$this->addAttribute('pattern', $this->type);

				break;
			}
		}

	public function setDataMask(\PHPFUI\Page $page, string $mask) : Input
		{
		$page->addTailScript('jquery.mask.min.js');
		$this->setAttribute('data-mask', $mask);

		return $this;
		}

	/**
	 * Set a specific error
	 *
	 * @param string $error to display on form validation
	 *
	 */
	public function addErrorMessage(string $error) : Input
		{
		$this->errorMessages[$error] = true;

		return $this;
		}

	/**
	 * Get the error message for placement else where. If this is
	 * called, the error mesage will not be incorporated
	 * automatically, but must be placed by the caller
	 */
	public function getError() : ?\PHPFUI\HTML5Element
		{
		if (! $this->error)
			{
			$this->error = new \PHPFUI\HTML5Element('label');
			$this->error->addClass('form-error');
			$this->error->add(implode('', array_keys($this->errorMessages)));
			$this->error->addAttribute('data-form-error-for', $this->getId());
			}

		return $this->error;
		}

	public function getHint() : ?\PHPFUI\HTML5Element
		{
		if ($this->hintText)
			{
			$this->hint = new \PHPFUI\HTML5Element('p');
			$this->hint->addClass('help-text');
			$this->hint->add($this->hintText);
			$this->addAttribute('aria-describedby', $this->hint->getId());
			}

		return $this->hint;
		}

	/**
	 * Return the label for the input field
	 *
	 */
	public function getLabel() : string
		{
		return $this->label;
		}

	/**
	 * Set a hint
	 *
	 * @param string $hint to display with input
	 *
	 */
	public function setHint(string $hint) : Input
		{
		$this->hintText = $hint;

		return $this;
		}

	/**
	 * Set a label if not specified in constructor
	 *
	 *
	 */
	public function setLabel(string $label) : Input
		{
		$this->label = $label;

		return $this;
		}

	/**
	 * Set required
	 *
	 * @param bool $required default true
	 *
	 * @return MonthYear
	 */
	public function setRequired(bool $required = true) : Input
		{
		$this->required = $required;
		$this->addAttribute('required');

		return $this;
		}

	public function toggleFocus(\PHPFUI\HTML5Element $element) : Input
		{
		$this->addAttribute('data-toggle-focus', $element->getId());
		$element->addClass('is-hidden');
		$element->addAttribute('data-toggler', 'is-hidden');

		return $this;
		}

	protected function getEnd() : string
		{
		return parent::getEnd() . $this->getHint();
		}

	protected function getStart() : string
		{
		$this->addAttribute('onkeypress', 'return event.keyCode!=13;');
		$label = null;

		if ($this->label)
			{
			$label = new \PHPFUI\HTML5Element('label');
			$label->add($this->getToolTip($this->label));
			}

		if ($this->required)
			{
			if ($label)
				{
				$label->add(' <small>Required</small>');
				}
			}

		if (! $this->error && $this->errorMessages && ! $this->started)
			{
			$this->started = true;
			$error = new \PHPFUI\HTML5Element('span');
			$error->add(implode('', array_keys($this->errorMessages)));
			$error->addClass('form-error');
			$this->addAttribute('aria-errormessage', $error->getId());
			$this->add($error);
			}

		return $label . parent::getStart();
		}
	}
