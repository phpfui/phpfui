<?php

namespace PHPFUI;

/**
 * The Form class handles all the housekeeping of dealing with forms, including automatically
 * setting up validation, a CSRF field and handling a submit button. Form submissions can be
 * detected with isMyCallback.  If it returns true, you should do appropriate work
 */
class Form extends \PHPFUI\HTML5Element
	{
	use \PHPFUI\Traits\Page;

	private bool $areYouSure = true;

	private \PHPFUI\Interfaces\Page $page;

	private bool $started = false;

	private array $submitValue = [];

	/**
	 * Form needs a Page, as it adds things to the page to handle automatic abide validation
	 *
	 * @param Submit $submit the submit button.  Passing the submit button does not add it to the page, you must do that elsewhere, but it does set up automatic
	 * callback notification.
	 * @param string $successFunctionName global JavaScript function
	 *  						 to execute on page submission success. It will
	 *  						 be passed one parameter which is the response
	 *  						 from the POST, which is set via
	 *  						 Page::setResponse or setRawResponse
	 */
	public function __construct(\PHPFUI\Interfaces\Page $page, ?\PHPFUI\Submit $submit = null, string $successFunctionName = '')
		{
		parent::__construct('form');
		$this->addAttribute('novalidate');
		$this->page = $page;
		$this->addAttribute('data-abide');
		$this->setAttribute('method', 'post');
		$this->addAttribute('accept-charset', 'UTF-8');
		$this->addAttribute('enctype', 'multipart/form-data');

		if ($submit)
			{
			$this->addSubmitButtonCallback($submit, $successFunctionName);
			}
		}

	public function addSubmitButtonCallback(\PHPFUI\Submit $submit, string $successFunctionName) : self
		{
		$submitButtonId = $submit->getId();
		$name = $submit->getAttribute('name');
		$value = $submit->getAttribute('value');
		$this->submitValue[$name] = $value;
		$id = $this->getId();
		$this->page->addJavaScript("$(document).ready(function(){formInit($('#{$id}'),$('#{$submitButtonId}'),'{$name}','{$value}','{$successFunctionName}');})");
		$js = <<<JAVASCRIPT
function formInit(form,submit,submitName,submitValue,successFunction){
	form.on("submit", function(ev) {ev.preventDefault();}).on('formvalid.zf.abide',function(e){
		var color=submit.css('background-color'), text=submit.html();
		e.preventDefault();
		var btn=$(this).find('button.submit:focus');
		if (!btn.length) {/* macHack! Safari does not keep the pressed submit button in focus, so get the first */
			btn=$(this).find('button.submit');
			}
		if(btn[0].name!=submitName||btn[0].value!=submitValue){
			form.submit();/* submit the form if not the button passed for special handling */
			return 0;
			}
		$.ajax({type:'POST',dataType:'html',data:form.serialize()+'&'+btn[0].name+'='+btn[0].value,
			beforeSend:function(request){
				submit.html('Saving').css('background-color','black');
				request.setRequestHeader('Upgrade-Insecure-Requests', '1');
				request.setRequestHeader('Accept', 'application/json');
			},
		success:function(response){
			var data;
			try{
				data=JSON.parse(response);
			}catch(e){
				alert('Error: '+response);
			}
			submit.html(data.response).css('background-color',data.color);
			if(successFunction>'')window[successFunction](data);
			setTimeout(function(){
				submit.html(text).css('background-color',color);},3000);
			},
		error:function (xhr, ajaxOptions, thrownError){
			submit.html(ajaxOptions+': '+xhr.status+' '+thrownError).css('background-color','red');
			setTimeout(function(){
				submit.html(text).css('background-color',color);},3000);
			},
		})
	})
}
JAVASCRIPT;
		$js = \str_replace(["\t", "\n"], '', $js);
		$this->page->addJavaScript($js);

		return $this;
		}

	/**
	 * Returns true if the submit button passed in the ctor or here was pressed by the user.
	 */
	public function isMyCallback(?\PHPFUI\Submit $submit = null) : bool
		{
		[$name, $value] = $this->getSubmitValues($submit);

		return \PHPFUI\Session::checkCSRF() && $name && ! empty($_POST[$name]) && $_POST[$name] == $value;
		}

	/**
	 * Any clickable element passed to this function will issue an AJAX call to save the form.
	 *
	 * @param \PHPFUI\HTML5Element $button to click (generally to do something else on the form, but not the save button)
	 * @param \PHPFUI\Submit $submit optional button to emulate a click for, defaults to Submit button used in the ctor
	 */
	public function saveOnClick(\PHPFUI\HTML5Element $button, ?\PHPFUI\Submit $submit = null) : Form
		{
		[$name, $value] = $this->getSubmitValues($submit);
		$id = $this->getId();
		$js = "var form{$id}=$(\"#{$id}\");";
		$js .= "$.ajax({type:\"POST\",dataType:\"html\",data:form{$id}.serialize()+\"&{$name}={$value}\"});";

		if ($this->areYouSure)
			{
			$js .= "form{$id}.trigger(\"reinitialize.areYouSure\")";
			}
		$button->addAttribute('onclick', $js);

		return $this;
		}

	/**
	 * Forms automatically ask the user if they are sure they want to navigate away from the page if the
	 * user has entered any data.  You can use this to turn off that behavior.  A good example of why
	 * you might want to do this is search criteria type forms where the data is not normally saved.
	 */
	public function setAreYouSure(bool $areYouSure = true) : Form
		{
		$this->areYouSure = $areYouSure;

		return $this;
		}

	protected function getStart() : string
		{
		if (! $this->started)
			{
			$this->started = true;
			$areYouSure = '';

			if ($this->areYouSure)
				{
				$this->page->addTailScript('jquery.are-you-sure.js');
				$id = $this->getId();
				$this->page->addJavaScript('$("#' . $id . '").on("submit",function(){$("#' . $id . '").trigger("reinitialize.areYouSure")}).areYouSure({"addRemoveFieldsMarksDirty":true})');
				}

			if ('get' != \strtolower($this->getAttribute('method')))
				{
				$this->add(new \PHPFUI\Input\Hidden(\PHPFUI\Session::csrfField(), \PHPFUI\Session::csrf()));
				}
			}

		return parent::getStart();
		}

	private function getSubmitValues(?\PHPFUI\Submit $submit = null) : array
		{
		if ($submit)
			{
			$name = $submit->getAttribute('name');
			$value = $submit->getAttribute('value');
			}
		else
			{
			$name = $value = '';

			foreach ($this->submitValue as $name => $value)
				{
				break; // just want first entry in the array
				}
			}

		return [$name, $value];
		}
	}
