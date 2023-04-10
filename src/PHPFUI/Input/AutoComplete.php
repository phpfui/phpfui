<?php

namespace PHPFUI\Input;

/**
 * AutoComplete allows you to have an autocomplete field for any
 * arbitrary data source. Based on jQuery-Autocomplete
 *
 * @link https://github.com/devbridge/jQuery-Autocomplete
 */
class AutoComplete extends \PHPFUI\Input\Input
	{
	use \PHPFUI\Traits\Page;

	protected string $className;

	protected \PHPFUI\Input\Hidden $hidden;

	protected bool $noFreeForm = false;

	/** @var array<string, mixed> */
	protected array $options = [];

	/**
	 * Construct a AutoComplete.
	 *
	 * **Required callback behavior:**
	 *
	 * The callback function must take an array and returns an
	 * array.
	 *
	 * **Input Array:**
	 *
	 * If the input array contains an index named **'save'** then the
	 * user has indicated they have selected text value passed in
	 * the **'AutoComplete'** index. This generally means you should set
	 * the value of the hidden field (set / getHiddenField) to the
	 * value of **'AutoComplete'**. If save is not set, you must return
	 * matches for the text in **'AutoComplete'** in the format
	 * descriped below.
	 *
	 * **Return Array:**
	 *
	 * Has one index **'suggestions'** that contains an array of matches
	 * in the form of `['value' => 'Text to display', 'data' => 123]`.
	 * If **'save'** is specified, the **'suggestions'** value should be an
	 *  empty array.
	 *
	 * @param \PHPFUI\Page $page requires JS
	 * @param callable $callback See above for correct callback
	 *                             behavior
	 * @param string $type of input field
	 * @param string $name of field
	 * @param string $label for field, optional
	 * @param ?string $value initial value, optional
	 *
	 */
	public function __construct(protected \PHPFUI\Page $page, protected $callback, string $type, string $name, ?string $label = null, ?string $value = null)
		{
		$this->hidden = new \PHPFUI\Input\Hidden($name, $value);
		$name .= 'Text';
		parent::__construct($type, $name, $label, $value);
		$this->hidden->setId($this->getId() . 'hidden');
		$this->add($this->hidden);
		$this->className = \basename(\str_replace('\\', '/', self::class));
		$this->page->addTailScript('jquery.autocomplete.js');
		$this->addAttribute('autocomplete', 'off');

		if (isset($_POST[$this->className]) && \PHPFUI\Session::checkCSRF() && $_POST['fieldName'] == $name)
			{
			$returnValue = \json_encode(\call_user_func($this->callback, $_POST));

			if ($returnValue)
				{
				$returnValue = \str_replace('&amp;', '&', $returnValue); // need both to remove pesky &amp;!
				$returnValue = \PHPFUI\TextHelper::unhtmlentities($returnValue);  // need this too!
				$this->page->setRawResponse($returnValue);
				}
			}
		$csrf = \PHPFUI\Session::csrf("'");
		$csrfField = \PHPFUI\Session::csrfField();
		$dollar = '$';
		$this->options = [
			'minChars' => 3,
			'type' => "'POST'",
			'autoSelectFirst' => true,
			'showNoSuggestionNotice' => true,
			'paramName' => "'{$this->className}'",
			'serviceUrl' => "'{$this->page->getBaseURL()}'",
			'params' => ['fieldName' => "'{$name}'", $csrfField => $csrf],
			'onSelect' => "function(suggestion){if(noFF){{$dollar}('#'+id).attr('placeholder',suggestion.value).attr('value','');};" .
																	"{$dollar}('#'+id+'hidden').val(suggestion.data).change();" .
																	"{$dollar}.ajax({type:'POST',traditional:true,data:{{$csrfField}:{$csrf},save:true,fieldName:'{$name}',{$this->className}:suggestion.data}})}",
		];
		}

	/**
	 * Add an option for jQuery-Autocomplete.
	 *
	 * @link https://github.com/devbridge/jQuery-Autocomplete
	 */
	public function addAutoCompleteOption(string $option, mixed $value) : static
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
	 */
	public function getHiddenField() : \PHPFUI\Input\Hidden
		{
		return $this->hidden;
		}

	/**
	 * Called recursively by Reveal to force fixed postion autocomplete hints.
	 */
	public function inReveal(bool $isInRevealModal = true) : static
		{
		return $this->addAutoCompleteOption('forceFixPosition', $isInRevealModal);
		}

	/**
	 * Remove an option for jQuery-Autocomplete.
	 *
	 * @link https://github.com/devbridge/jQuery-Autocomplete
	 *
	 * @param string $option to remove
	 */
	public function removeAutoCompleteOption(string $option) : static
		{
		unset($this->options[$option]);

		return $this;
		}

	/**
	 * If No Free Form is turned on, then the user can only pick
	 * suggested values.  It is off by default allowing the user to
	 * specify any text and not just suggestions.
	 */
	public function setNoFreeForm(bool $on = true) : static
		{
		$this->noFreeForm = $on;

		if ($this->noFreeForm)
			{
			$this->addAttribute('placeholder', \str_replace("'", '&#39;', $this->value));
			$this->value = '';
			}
		else
			{
			$this->value = $this->getAttribute('placeholder');
			$this->deleteAttribute('placeholder');
			}

		return $this;
		}

	protected function getEnd() : string
		{
		$id = $this->getId();
		$noFreeForm = (int)($this->noFreeForm);
		$this->page->addJavaScript("{$id}('{$id}','{$this->name}',{$noFreeForm})");

		return parent::getEnd();
		}

	protected function getStart() : string
		{
		$id = $this->getId();

		if ($this->required)
			{
			$this->setAutoCompleteRequired($this->page, $this);
			}

		$js = "function {$id}(id,fieldName,noFreeForm){var noFF=noFreeForm;";
		$js .= '$("#"+id).devbridgeAutocomplete(' . \PHPFUI\TextHelper::arrayToJS($this->options) . ')}';
		$this->page->addJavaScript($js);

		return parent::getStart();
		}
	}
