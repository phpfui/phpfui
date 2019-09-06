<?php

namespace PHPFUI;

/**
 * The Form class handles all the housekeeping of dealing with forms, including automatically setting up validation, a CSRF field and handling a submit button.
 * Form submissions can be detected with isMyCallback and appropriate work on if it returns true.
 */
class Form extends HTML5Element
	{
	private $areYouSure = true;
	private $js = '';
	private $page;
	private $started = false;

	private $submitName = '';
	private $submitValue = '';

	/**
	 * Form needs a Page, as it adds things to the page to handle automatic abide validation
	 *
	 * @param Submit $submit the submit button.  Passing the submit button does not add it to the page, you must do that elsewhere, but it does set up automatic
	 * callback notification.
	 * @param string $successJS JavaScript executed on page success. data will have what ever values are set in Page::setResponse or add additional
	 * parameters with Page::setRawResponse
	 */
	public function __construct(Page $page, Submit $submit = null, string $successJS = '')
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
			$submitButtonId = $submit->getId();
			$this->submitName = $submit->getAttribute('name');
			$this->submitValue = $submit->getAttribute('value');
			$id = $this->getId();
			$this->js = <<<JAVASCRIPT
$(document).ready(function(){var form=$('#{$id}');
form.on("submit", function(ev) {ev.preventDefault();}).on('formvalid.zf.abide',function(e){
	var submit=$('#{$submitButtonId}'), color=submit.css('background-color'), text=submit.prop('value');
	e.preventDefault();
  ~areYouSure~
  var btn=$(this).find('input[type=submit]:focus');
  if (!btn.length) {// macHack! Safari does not keep the pressed submit button in focus, so get the first
    btn=$(this).find('input[type=submit]');
    }
  if(btn[0].name!='{$this->submitName}'||btn[0].value!='{$this->submitValue}'){
    form.submit();// submit the form if not the button passed for special handling
    return 0;
    }
  $.ajax({type:'POST',dataType:'html',data:form.serialize()+'&'+btn[0].name+'='+btn[0].value,
    beforeSend:function(request){
      submit.prop('value','Saving').css('background-color','black');
      request.setRequestHeader('Upgrade-Insecure-Requests', '1');
      request.setRequestHeader('Accept', 'application/json');
  },
  success:function(response){
    var data;
    try{
      data=JSON.parse(response);
    } catch(e){
      alert('Error: '+response);
    }
    submit.prop('value',data.response).css('background-color',data.color);
    {$successJS};
    setTimeout(function(){
      submit.prop('value',text).css('background-color',color);},3000);
  },
  error:function (xhr, ajaxOptions, thrownError){
    submit.prop('value',ajaxOptions+': '+xhr.status+' '+thrownError).css('background-color','red');
    setTimeout(function(){
      submit.prop('value',text).css('background-color',color);},3000);
  },
  });
});
});
JAVASCRIPT;
			}
		}

	/**
	 * Returns true if the submit button passed in the ctor was pressed.
	 *
	 */
	public function isMyCallback() : bool
		{
		return Session::checkCSRF() && $this->submitName && ! empty($_POST[$this->submitName]) && $_POST[$this->submitName] == $this->submitValue;
		}

	/**
	 * Any clickable element passed to this function will issue an AJAX call to save the form.
	 *
	 *
	 */
	public function saveOnClick(HTML5Element $button) : Form
		{
		$js = "var form=$(\"#{$this->getId()}\");";
		$js .= "$.ajax({type:\"POST\",dataType:\"html\",data:form.serialize()+\"&{$this->submitName}={$this->submitValue}\"});";

		if ($this->areYouSure)
			{
			$js .= 'form.trigger("reinitialize.areYouSure");';
			}
		$button->addAttribute('onclick', $js);

		return $this;
		}

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
				$this->page->addTailScript('/js/jquery.are-you-sure.js');
				$id = $this->getId();
				$this->page->addJavaScript('$("#' . $id . '").areYouSure({"addRemoveFieldsMarksDirty":true});');
				$areYouSure = "$('#{$id}').trigger('reinitialize.areYouSure');";
				}
			$this->page->addJavaScript(str_replace('~areYouSure~', $areYouSure, $this->js));

			if ('get' != $this->getAttribute('method'))
				{
				$this->add(new \PHPFUI\Input\Hidden(Session::csrfField(), Session::csrf()));
				}
			}

		return parent::getStart();
		}

	}
