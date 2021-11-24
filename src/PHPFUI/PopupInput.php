<?php

namespace PHPFUI;

class PopupInput
	{
	private string $inputId;

	private string $revealId;

	private string $updateFieldId;

	public function __construct(\PHPFUI\Interfaces\Page $page, Input $input)
		{
		$button = new \PHPFUI\Button('reveal');
		$reveal = new \PHPFUI\Reveal($page, $button);
		$updateField = new \PHPFUI\Input\Hidden($input->getName() . 'Id');
		$reveal->add($updateField);
		$reveal->add($input);
		$this->revealId = $reveal->getId();
		$revealSubmit = new \PHPFUI\Button('Save');
		$this->updateFieldId = $updateField->getId();
		$this->inputId = $input->getId();
		$closeId = $revealSubmit->getId();
		$revealSubmit->addAttribute('onclick', 'document.getElementById($("#' . $this->updateFieldId . '").val()).value=$("#' . $this->inputId . '").val();');
		$page->addJavaScript("$('#{$closeId}').click(function(e){e.preventDefault();$('#{$this->revealId}').foundation('close');});");
		$reveal->add($reveal->getButtonAndCancel($revealSubmit));
		}

	public function getLoadJS(\PHPFUI\HTML5Element $input)
		{
		return '$("#' . $this->inputId . '").val($("#' . $input->getId() . '").val());' . '$("#' . $this->updateFieldId . '").val("' .
			$input->getId() . '");' . '$("#' . $this->revealId . '").foundation("open");';
		}
	}
