<?php

namespace PHPFUI\Input;

/**
 * Password with an eye icon at the end to show the user the password.
 */
class PasswordEye extends \PHPFUI\Input\Password
	{

	/**
	 * Construct a Password input
	 *
	 * @param string $name of the field
	 * @param string $label defaults to empty
	 * @param ?string $value defaults to empty
	 */
	public function __construct(string $name, string $label = '', ?string $value = '')
		{
		parent::__construct($name, $label, $value);
		}

	// Special rendering logic:
	//
	// We need to render an InputGroup, but this object should behave like a regular PHPFUI\Input\Password
	// So we null out start end end rendering
	// Then in getBody, we upCastCopy the object into something that is not us (PHPFUI\Input\Password), so our getBody will not be called.
	// Then we make an InputGroup, add the new password object into it, and the yukky JavaScript

	public function getStart() : string
		{
		return '';
		}

	public function getBody() : string
		{
		$inputGroup = new \PHPFUI\InputGroup();
		$password = $this->upCastCopy(new \PHPFUI\Input\Password('p'), $this);
		$icon = new \PHPFUI\IconBase('fa-eye');
		$icon->addClass('far');
		$iconId = $icon->getId();
		$passwordId = $password->getId();
		$js = "var iconId=$('#{$iconId}'),passwordId=$('#{$passwordId}'),remove='',add='-slash',type='text';" .
				"if(iconId.hasClass('fa-eye'+add)){remove=add;add='';type='password'};iconId.removeClass('fa-eye'+remove);" .
				"iconId.addClass('fa-eye'+add);passwordId.prop('type',type);";
		$icon->setAttribute('onclick', str_replace("'", '"', $js));
		$inputGroup->addInput($password);
		$inputGroup->addLabel($icon);

		return $inputGroup;
		}

	public function getEnd() : string
		{
		return '';
		}

	}

