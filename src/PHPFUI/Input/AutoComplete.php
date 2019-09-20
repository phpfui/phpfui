<?php

namespace PHPFUI\Input;

/**
 * AutoComplete allows you to have an autocomplete field for any
 * arbitray data source. Based on
 * https://github.com/devbridge/jQuery-Autocomplete
 */
class AutoComplete extends Input
	{
	protected $callback;
	protected $className;
	protected $hidden;
	protected $noFreeForm = false;
	protected $options = [
    'minChars'        => 3,
    'type'            => "'POST'",
    'autoSelectFirst' => 'true',
  ];
	protected $page;

	private static $count = 0;

	/**
	 * Construct a AutoComplete.
	 *
	 * @param Page $page requires JS
	 * @param callable $callback See below for correct callback
	 *                             behavior
	 * @param string $type of input field
	 * @param string $name of field
	 * @param string $label for field, optional
	 * @param ?string $value initial value, optional
	 *
	 * Required callback behavior:
	 *
	 * The callback function must take an array and returns an
	 * array.
	 *
	 * Input Array:
	 *
	 * If the input array contains an index named 'save' then the
	 * user has indicated they have selected text value passed in
	 * the 'AutoComplete' index. This generally means you should set
	 * the value of the hidden field (set getHiddenField) to the
	 * value of 'AutoComplete'. If save is not set, you must return
	 * matches for the text in 'AutoComplete' in the format
	 * descriped below.
	 *
	 * Return Array:
	 *
	 * Has one index 'suggestions' that contains an array of matches
	 * in the form of ['value' => 'Text to display', 'data' => 123].
	 * If 'save' is specified, the 'suggestions' value should be an
	 * empty array.
	 */
	public function __construct(\PHPFUI\Page $page, callable $callback, string $type, string $name, string $label = null, ?string $value = null)
		{
		$this->hidden = new \PHPFUI\Input\Hidden($name, $value);
		$name .= 'Entered';
		parent::__construct($type, $name, $label, $value);
		$this->hidden->setId($this->getId() . 'hidden');
		$this->add($this->hidden);
		$this->className = basename(__CLASS__);

		if (false !== ($pos = strrpos($this->className, '\\')))
			{
			$this->className = substr($this->className, $pos + 1);
			}

		$this->page = $page;
		$this->page->addTailScript('/jquery-autocomplete/jquery.autocomplete.js');
		$this->callback = $callback;
		$this->addAttribute('autocomplete', 'off');

		if (! self::$count++)
			{
			$url = $this->page->getBaseURL();
			$csrf = \PHPFUI\Session::csrf("'");
			$csrfField = \PHPFUI\Session::csrfField();
			$dollar = '$';
			$js = "function {$this->className}(id,fieldName,noFreeForm){var noFF=noFreeForm;";
			$js .= "{$dollar}('#'+id).devbridgeAutocomplete({showNoSuggestionNotice:true,forceFixPosition:true,paramName:'{$this->className}',serviceUrl:'{$url}',params:{fieldName:fieldName,{$csrfField}:{$csrf}},";

			foreach ($this->options as $option => $value)
				{
				$js .= "{$option}:{$value},";
				}

			$js .= 'onSelect:function(suggestion){';
			$js .= "if(noFF){var fld={$dollar}('#'+id);fld.attr('placeholder',suggestion.value);fld.attr('value','');};";
			$js .= "{$dollar}('#'+id+'hidden').val(suggestion.data);";
			$js .= "{$dollar}.ajax({type:'POST',traditional:true,data:{{$csrfField}:{$csrf},save:true,fieldName:fieldName,{$this->className}:suggestion.data}});}})}";
			$this->page->addJavaScript($js);
			}

		if (isset($_POST[$this->className]) && \PHPFUI\Session::checkCSRF() && $_POST['fieldName'] == $name)
			{
			$returnValue = json_encode(call_user_func($this->callback, $_POST));

			if ($returnValue)
				{
				$returnValue = str_replace('&amp;', '&', $returnValue); // need both to remove pesky &amp;!
        $returnValue = \PHPFUI\TextHelper::unhtmlentities($returnValue);  // need this too!
        $this->page->setRawResponse($returnValue);
				}
			}
		}

	/**
	 * Add an option for
	 * https://github.com/devbridge/jQuery-Autocomplete
	 *
	 *
	 */
	public function addOption(string $option, string $value) : AutoComplete
		{
		$this->options[$option] = $value;

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
	public function getHiddenField()
		{
		return $this->hidden;
		}

	/**
	 * Remove an option for
	 * https://github.com/devbridge/jQuery-Autocomplete
	 *
	 * @param string $option to remove
	 *
	 */
	public function removeOption(string $option) : AutoComplete
		{
		if (isset($this->options[$option]))
			{
			unset($this->options[$option]);
			}

		return $this;
		}

	/**
	 * If No Free Form is turned on, then the user can only pick
	 * suggested values.  It is off by default allowing the user to
	 * specify any text and not just suggestions.
	 *
	 * @param bool $on default true
	 *
	 */
	public function setNoFreeForm(bool $on = true) : AutoComplete
		{
		$this->noFreeForm = $on;

		if ($this->noFreeForm)
			{
			$this->addAttribute('placeholder', $this->value);
			$this->value = '';
			}
		else
			{
			$this->value = $this->getAttribute('placeholder');
			$this->deleteAttribute('placeholder');
			}

		return $this;
		}

	/**
	 * Set required
	 *
	 * @param bool $required default true
	 *
	 * @return AutoComplete
	 */
	public function setRequired(bool $required = true) : Input
		{
		return $this->setNoFreeForm($required);
		}

	protected function getEnd() : string
		{
		$id = $this->getId();
		$noFreeForm = (int) ($this->noFreeForm);
		$this->page->addJavaScript("{$this->className}('{$id}','{$this->name}',{$noFreeForm})");

		return '';
		}
	}
