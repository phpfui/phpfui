<?php

namespace PHPFUI\Input;

/**
 * Implements autocomplete for a Select
 *
 * Use instead of a Select if you have a long list
 */
class SelectAutoComplete extends Select
	{
	protected $acFieldId;
	protected $acInput;
	protected $arrayName;
	protected $freeformInput;
	protected $hidden;
	protected $autoCompleteOptions = [
		'minChars'        => 1,
		'type'            => "'POST'",
		'autoSelectFirst' => 'true',
		'lookup'          => 'arrayName',
		'onSelect'        => 'function(suggestion){ac.attr("placeholder",suggestion.value);ac.val("");fld.val(suggestion.data);fld.change()}',
	];

	protected $page;
	protected $realName;
	protected $toolTip;

	/**
	 * Construct a SelectAutoComplete. Add options as you would a
	 * regular Select
	 *
	 * @param Page $page requires JavaScript
	 * @param string $name of the field
	 * @param string $label optional
	 * @param bool $freeformInput if true allow anything to be
	 *  					 entered, but will suggest options
	 */
	public function __construct(\PHPFUI\Page $page, string $name, string $label = '', bool $freeformInput = false)
		{
		$this->freeformInput = $freeformInput;
		$suffix = '';
		$nameField = $name;

		if (strstr($nameField, '[]'))
			{
			$suffix = '[]';
			$nameField = str_replace($suffix, '', $nameField);
			}

		$nameField .= 'Text';
		parent::__construct($nameField, $label);
		$this->acInput = new \PHPFUI\Input\Text($nameField, $label);
		$this->realName = $name;
		$this->page = $page;
		$this->type = 'text'; // really a text Input field, not a Select
		$this->page->addTailScript('jquery.autocomplete.js');
		$this->hidden = new \PHPFUI\Input\Hidden($this->realName);
		$this->hidden->getId();
		}

	/**
	 * Add an option for
	 * https://github.com/devbridge/jQuery-Autocomplete
	 */
	public function addAutoCompleteOption(string $option, string $value) : \PHPFUI\Input\SelectAutoComplete
		{
		$this->autoCompleteOptions[$option] = $value;

		return $this;
		}

	/**
	 * Remove an option for
	 * https://github.com/devbridge/jQuery-Autocomplete
	 *
	 * @param string $option to remove
	 */
	public function removeAutoCompleteOption(string $option) : \PHPFUI\Input\SelectAutoComplete
		{
		unset($this->autoCompleteOptions[$option]);

		return $this;
		}

	/**
	 * Returns the hidden field which is where the autocompleted
	 * value will be stored. The hidden field name is the same name
	 * as the AutoComplete field was constructed with. This should
	 * generally be used to save the value the user has selected
	 * when 'save' is passed to the callback.
	 *
	 * @return string
	 */
	public function getHiddenField() : \PHPFUI\Input\Hidden
		{
		return $this->hidden;
		}

	/**
	 * Called recursively by Reveal to force fixed postion autocomplete hints.
	 */
	public function inReveal(bool $isInRevealModal = true) : \PHPFUI\Input\SelectAutoComplete
		{
		return $this->addAutoCompleteOption('forceFixPosition', $isInRevealModal);
		}

	/**
	 * If you have mutiple SelectAutoComplete fields of the same
	 * type on a page, you can set the array name to avoid multiple
	 * copies of the JavaScript array used for autocomplete.
	 *
	 * Set the second and subsequent SelectAutoComplete fields to an
	 * array name of the first SelectAutoComplete name.
	 *
	 * @param string $name of array
	 *
	 * @return SelectAutoComplete
	 */
	public function setArray($name) : \PHPFUI\Input\SelectAutoComplete
		{
		$this->arrayName = $name;

		return $this;
		}

	/**
	 * Set the tool tip.  Can either be a ToolTip or a string.  If it is a string, it will be converted to a ToolTip
	 *
	 * @param string ,ToolTip $tip
	 *
	 * @return HTML5Element
	 */
	public function setToolTip($tip) : \PHPFUI\HTML5Element
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
			$js = "var {$this->arrayName}=[";
			$comma = '';

			foreach ($this->options as $option)
				{
				if (! $option['disabled'])
					{
					$label = $option['label'];
					$label = str_replace('&amp;', '&', $label); // need both to remove pesky &amp;!
					$label = \PHPFUI\TextHelper::unhtmlentities($label);  // need this too!
					$label = str_replace("'", "\'", $label);
					$js .= "{$comma}{data:'{$option['value']}',value:'{$label}'}";
					$comma = ',';
					}
				}

			$js .= '];';
			}
		else
			{
			$this->arrayName .= 'Array';
			}

		$id = $this->getId();
		$js .= "{$id}('{$this->acFieldId}','{$this->hidden->getId()}',{$this->arrayName})";
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

		$this->addAttribute('placeholder', $initLabel);
		$this->addAttribute('autocomplete', 'off');
		$this->hidden->setValue($initValue);
		$onChange = $this->getAttribute('onchange');

		if ($onChange)
			{
			$this->deleteAttribute('onchange');
			$this->hidden->addAttribute('onchange', $onChange);
			}

		if ($this->required)
			{
			$js = 'function SelectAutoCompleteRequired($el,required,parent){var name=$el.attr("name").slice(0,-4);' .
				'return $("[name=\'"+name+"\']").val().length!=0||$("[name=\'"+name+"Text\']").val().length!=0;};';
			$this->page->addJavaScript($js);
			$this->page->addPluginDefault('Abide', "validators['SelectAutoCompleteRequired']", 'SelectAutoCompleteRequired');
			}

		$text = $this->upCastCopy($this->acInput, $this);
		$text->setToolTip($this->toolTip);

		if ($this->required)
			{
			$text->deleteAttribute('required');
			$text->addAttribute('data-validator', 'SelectAutoCompleteRequired');
			}

		if ($this->freeformInput)
			{
			$this->page->addJavaScript('$("#' . $text->getId() . '").on("change", function(){var f=$("#' . $this->hidden->getId() . '");f.val($(this).val());f.change()})');
			}

		$this->acFieldId = $text->getId();

		return $text->output() . $this->hidden->output();
		}
	}
