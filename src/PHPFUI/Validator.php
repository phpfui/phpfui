<?php

namespace PHPFUI;

class Validator
	{
	protected string $functionName;

	protected string $javaScript;

	protected bool $addedToPage = false;

	/**
	 * Create a custom Abide validator.  Steps for use:
	 *
	 * * Give it name. The current class name is a nice default.
	 * * Provide the JavaScript to do the validation (required).  See getJavaScriptTemplate()
	 * * Call setValidator on \PHPFUI\Input object
	 * * Add it to the page with addAbideValidator
	 *
	 * @param string $validatorName is the validator name used in HTML markup
	 * @param string $javaScriptFunction called to do the validation
	 */
	public function __construct(protected string $validatorName, string $javaScriptFunction = '')
		{
		$this->setJavaScript($javaScriptFunction);
		}

	public function getValidatorName() : string
		{
		return $this->validatorName;
		}

	public function getFunctionName() : string
		{
		return $this->functionName;
		}

	/**
	 * Returns the JavaScript that is added to the page when addAbideValidator is called
	 */
	public function getJavaScript() : string
		{
		if ($this->addedToPage)
			{
			return '';
			}

		$this->addedToPage = true;

		return $this->javaScript;
		}

	public function setJavaScript(string $javaScriptFunction) : self
		{
		$this->addedToPage = false;
		$this->javaScript = $javaScriptFunction;
		$javaScriptFunction = \trim(\str_replace('function ', '', $javaScriptFunction));
		$this->functionName = \trim(\substr($javaScriptFunction, 0, \strpos($javaScriptFunction, '(')));

		return $this;
		}

	/**
	 * Most validation JavaScript follows a standard pattern:
	 *
	 * * Get the element value
	 * * If the value is empty and not required, don't bother to validate, simply not set and does not need to be set
	 * * Otherwise, perform some test passed in by $customJavaScript which should return true if it validates, otherwise false
	 *
	 * Local variables available to $customJavaScript
	 *
	 * * el: element being validated
	 * * required: boolean if input is required
	 * * parent: of el
	 * * to: el.val()
	 * * data: value of the data-validatorname attribute
	 * * from: value of element pointed to by the id data
	 *
	 * @param string $customJavaScript JavaScript using above variables returning true (validates) or false (not valid)
	 *
	 * @return string of JavaScript to be passed to setJavaScript
	 */
	protected function getJavaScriptTemplate(string $customJavaScript) : string
		{
		$js = "function {$this->validatorName}(el,required,parent){let to=el.val();if(to.length==0 && !required)return true;let data=el.attr('data-{$this->validatorName}');let from=$('#'+data).val();return({$customJavaScript});};";

		return $js;
		}
	}
