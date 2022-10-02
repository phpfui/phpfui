<?php

namespace PHPFUI\Input;

/**
 * Implements autocomplete for a Select
 *
 * Use instead of a Select if you have a long list
 */
class SelectAutoComplete extends \PHPFUI\Input\Select
	{
	use \PHPFUI\Traits\Page;

	protected string $acFieldId;

	protected \PHPFUI\Input\Text $acInput;

	protected string $arrayName = '';

	/** @var array<string, string | bool> */
	protected array $autoCompleteOptions = [
		'minChars' => '1',
		'type' => "'POST'",
		'autoSelectFirst' => 'true',
		'lookup' => 'arrayName',
		'onSelect' => 'function(suggestion){ac.attr("placeholder",suggestion.value);ac.val("");fld.val(suggestion.data);fld.change()}',
	];

	protected \PHPFUI\Input\Hidden $hidden;

	protected string $realName;

	protected string | \PHPFUI\ToolTip $toolTip = '';

	/**
	 * Construct a SelectAutoComplete. Add options as you would a
	 * regular Select
	 *
	 * @param \PHPFUI\Page $page requires JavaScript
	 * @param string $name of the field
	 * @param string $label optional
	 * @param bool $freeformInput if true allow anything to be
	 *  					 entered, but will suggest options
	 */
	public function __construct(protected \PHPFUI\Page $page, string $name, string $label = '', protected bool $freeformInput = false)
		{
		$suffix = '';
		$nameField = $name;

		if (\strstr($nameField, '[]'))
			{
			$suffix = '[]';
			$nameField = \str_replace($suffix, '', $nameField);
			}

		$nameField .= 'Text';
		parent::__construct($nameField, $label);
		$this->acInput = new \PHPFUI\Input\Text($nameField, $label);
		$this->realName = $name;
		$this->type = 'text'; // really a text Input field, not a Select
		$this->page->addTailScript('jquery.autocomplete.js');
		$this->hidden = new \PHPFUI\Input\Hidden($this->realName);
		$this->hidden->getId();
		}

	/**
	 * Add an option for jQuery-Autocomplete
	 *
	 * @link https://github.com/devbridge/jQuery-Autocomplete
	 */
	public function addAutoCompleteOption(string $option, mixed $value) : static
		{
		$this->autoCompleteOptions[$option] = $value;

		return $this;
		}

	/**
	 * Returns the hidden field which is where the autocompleted
	 * value will be stored. The hidden field name is the same name
	 * as the AutoComplete field was constructed with. This should
	 * generally be used to save the value the user has selected
	 * when 'save' is passed to the callback.
	 */
	public function getHiddenField() : \PHPFUI\Input\Hidden
		{
		return $this->hidden;
		}

	/**
	 * Called recursively by Reveal to force fixed postion autocomplete hints.
	 */
	public function inReveal(bool $isInRevealModal = true) : self
		{
		return $this->addAutoCompleteOption('forceFixPosition', $isInRevealModal);
		}

	/**
	 * Remove an option for jQuery-Autocomplete
	 *
	 * @link https://github.com/devbridge/jQuery-Autocomplete
	 * @param string $option to remove
	 */
	public function removeAutoCompleteOption(string $option) : static
		{
		unset($this->autoCompleteOptions[$option]);

		return $this;
		}

	/**
	 * If you have mutiple SelectAutoComplete fields of the same
	 * type on a page, you can set the array name to avoid multiple
	 * copies of the JavaScript array used for autocomplete.
	 *
	 * Set the second and subsequent SelectAutoComplete fields to an
	 * array name of the first SelectAutoComplete name.
	 */
	public function setArray(string $name) : static
		{
		$this->arrayName = $name;

		return $this;
		}

	/**
	 * Set the tool tip.  Can either be a ToolTip or a string.  If it is a string, it will be converted to a ToolTip
	 */
	public function setToolTip(string | \PHPFUI\ToolTip $tip) : static
		{
		$this->toolTip = $tip;

		return $this;
		}

	protected function getBody() : string
		{
		return '';
		}

	protected function getEnd() : string
		{
		$js = '';

		if (! $this->arrayName)
			{
			$this->arrayName = "{$this->name}Array";
			}
		else
			{
			$this->arrayName .= 'Array';
			}

		$js = "var {$this->arrayName}=[";
		$comma = '';

		foreach ($this->options as $option)
			{
			if (! $option['disabled'])
				{
				$js .= "{$comma}{data:'{$this->escapeData($option['value'])}',value:'{$this->escapeData($option['label'])}'}";
				$comma = ',';
				}
			}
		$js .= '];';
		$this->page->addJavaScript($js);

		$id = $this->getId();
		$js = "{$id}('{$this->acFieldId}','{$this->hidden->getId()}',{$this->arrayName})";
		$this->page->addJavaScript($js);

		return '';
		}

	protected function getStart() : string
		{
		$dollar = '$';
		$options = \PHPFUI\TextHelper::arrayToJS($this->autoCompleteOptions);
		$id = $this->getId();

		$js = "function {$id}(acFieldId,hiddenFieldId,arrayName){var fld={$dollar}('#'+hiddenFieldId);var ac={$dollar}('#'+acFieldId);ac.devbridgeAutocomplete({$options});}";
		$this->page->addJavaScript($js);

		$initValue = $initLabel = '';

		foreach ($this->options as $option)
			{
			if ($option['selected'])
				{
				$initLabel = $option['label'];
				$initValue = $option['value'];
				$this->hidden->setValue($initValue);
				$this->acInput->setValue($initLabel);
				}
			}

		$this->setAttribute('placeholder', $initLabel);
		$this->setAttribute('autocomplete', 'off');
		$this->hidden->setValue($initValue);
		$onChange = $this->getAttribute('onchange');

		if ($onChange)
			{
			$this->deleteAttribute('onchange');
			$this->hidden->addAttribute('onchange', $onChange);
			}

		$text = $this->upCastCopy($this->acInput, $this);
		$text->setToolTip($this->toolTip);

		if ($this->required)
			{
			$this->setAutoCompleteRequired($this->page, $text);
			}

		if ($this->freeformInput)
			{
			$this->page->addJavaScript('$("#' . $text->getId() . '").on("change", function(){$("#' . $this->hidden->getId() . '").val($(this).val()).change()})');
			}

		$this->acFieldId = $text->getId();

		return $text . $this->hidden;
		}

	private function escapeData(?string $data) : string
		{
		if (null === $data)
			{
			return '';
			}

		$data = \str_replace('&amp;', '&', $data); // need both to remove pesky &amp;!
		$data = \PHPFUI\TextHelper::unhtmlentities($data);  // need this too!
		$data = \str_replace("'", "\'", $data);

		return $data;
		}
	}
