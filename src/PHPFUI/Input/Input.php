<?php

namespace PHPFUI\Input;

/**
 * Generic input class with default error handling
 */
abstract class Input extends \PHPFUI\Input
	{
	protected $error = null;

	protected $errorMessages = [];

	protected $hint = null;

	protected $hintText = '';

	protected $label = '';

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
	 * @throws \Exception if an invalid input type or a specific class exists for an input type like Date
	 */
	public function __construct(string $type, string $name = '', string $label = '', ?string $value = '')
		{
		parent::__construct($type, $name, $value);
		$this->label = $label;

		switch ($this->type)
			{
			case 'email':
				if (\PHPFUI\Language::$emailError)
					{
					$this->errorMessages[] = \PHPFUI\Language::$emailError;
					}
				$this->addAttribute('pattern', $this->type);

				break;

			case 'url':
				if (\PHPFUI\Language::$urlError)
					{
					$this->errorMessages[] = \PHPFUI\Language::$urlError;
					}
				$this->addAttribute('pattern', $this->type);

				break;

			case 'number':
				if (\PHPFUI\Language::$numberError)
					{
					$this->errorMessages[] = \PHPFUI\Language::$numberError;
					}

				break;

			case 'datetime-local':
				$this->addAttribute('pattern', 'datetime');

				break;

			}
		}

	/**
	 * Set a specific error
	 *
	 * @param string $error to display on form validation
	 */
	public function addErrorMessage(string $error) : Input
		{
		$this->errorMessages[] = $error;

		return $this;
		}

	/**
	 * Set all error messages
	 *
	 * @param array $errors to display on form validation
	 */
	public function setErrorMessages(array $errors) : Input
		{
		$this->errorMessages = $errors;

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
			$this->error = new \PHPFUI\HTML5Element('span'); // not really a label
			$this->error->addClass('form-error');
			$this->error->add(\implode('', $this->errorMessages));
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
	 */
	public function getLabel() : string
		{
		return $this->label;
		}

	public function setDataMask(\PHPFUI\Interfaces\Page $page, string $mask) : Input
		{
		$page->addTailScript('jquery.mask.min.js');
		$this->setAttribute('data-mask', $mask);

		return $this;
		}

	/**
	 * Set a hint
	 *
	 * @param string $hint to display with input
	 */
	public function setHint(string $hint) : Input
		{
		$this->hintText = $hint;
		$this->hint = null;

		return $this;
		}

	/**
	 * Set a label if not specified in constructor
	 */
	public function setLabel(string $label) : Input
		{
		$this->label = $label;

		return $this;
		}

	public function getRequired() : bool
		{
		return $this->required;
		}

	/**
	 * Set required
	 *
	 * @param bool $required default true
	 */
	public function setRequired(bool $required = true) : Input
		{
		$this->required = $required;

		if ($required)
			{
			$this->addAttribute('required', false);
			}
		else
			{
			$this->deleteAttribute('required');
			}

		return $this;
		}

	/**
	 * Toggle the passed in element when this field gets focus.
	 */
	public function toggleFocus(\PHPFUI\HTML5Element $element) : Input
		{
		$this->addAttribute('data-toggle-focus', $element->getId());
		$element->addClass('is-hidden');
		$element->addAttribute('data-toggler', 'is-hidden');

		return $this;
		}

	protected function getEnd() : string
		{
		$label = $this->label ? '</label>' : '';

		return parent::getEnd() . $label . $this->getHint();
		}

	protected function getStart() : string
		{
		$this->addAttribute('onkeypress', 'return event.keyCode!=13;');
		$label = '';

		if ($this->label)
			{
			$label = '<label>';
			$label .= $this->getToolTip($this->label);
			}

		if ($this->required && $label)
			{
			$label .= \PHPFUI\Language::$required;
			}

		if (! $this->error && $this->errorMessages && ! $this->started)
			{
			$this->started = true;
			$error = new \PHPFUI\HTML5Element('span');
			$error->add(\implode('', $this->errorMessages));
			$error->addClass('form-error');
			$this->addAttribute('aria-errormessage', $error->getId());
			$this->add($error);
			}

		return $label . parent::getStart();
		}

	protected function setAutoCompleteRequired(\PHPFUI\Page $page, \PHPFUI\Input\Input $text) : void
		{
		$js = 'function AutoCompleteRequired($el,required,parent){var name=$el.attr("name").slice(0,-4);' .
			'return $("[name=\'"+name+"\']").val().length!=0||$("[name=\'"+name+"Text\']").val().length!=0;};';
		$this->page->addJavaScript($js);
		$this->page->addPluginDefault('Abide', "validators['AutoCompleteRequired']", 'AutoCompleteRequired');
		$text->deleteAttribute('required');
		$text->addAttribute('data-validator', 'AutoCompleteRequired');
		}
	}
