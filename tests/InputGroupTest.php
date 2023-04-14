<?php

/**
 * This file is part of the PHPFUI package
 *
 * (c) Bruce Wells
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source
 * code
 */
class InputGroupTest extends \PHPFUI\HTMLUnitTester\Extensions
	{
	public function testPlainInput() : void
		{
		$inputGroup = new \PHPFUI\InputGroup();
		$inputGroup->addInput(new \PHPFUI\Input\Text('fred', 'Fred', 'Freddy'));
		$inputGroup->addLabel('Label');
		$inputGroup->addButton(new \PHPFUI\Button('Button'));
		$this->assertValidHtml($inputGroup);
		}

	/**
	 * @dataProvider providerSimpleInput
	 */
	public function testSimpleInputGroup(string $class, string $value) : void
		{
		$page = new \PHPFUI\Page();
		$page->setDebug(1);
		$inputGroup = new \PHPFUI\InputGroup();
		$parts = \explode('\\', $class);
		$base = \array_pop($parts);
		$input = new $class('name', $base, $value);
		$inputGroup->addInput($input);
		$inputGroup->addLabel('Label');

		if (\method_exists($input, 'setHint'))
			{
			$input->setHint('This is the hint');
			}

		if (\method_exists($input, 'setToolTip'))
			{
			$input->setToolTip('This is the tooltip');
			}

		if (\method_exists($input, 'addErrorMessage'))
			{
			$input->addErrorMessage('My error message');
			}
		$inputGroup->addButton(new \PHPFUI\Button('Button'));
		$page->add($inputGroup);
		$this->assertValidHtml($page);
		}

	/**
	 * @return array<array<string>>
	 */
	public static function providerSimpleInput() : array
		{
		return [
			['PHPFUI\\Input\\Email', 'test@example.com'],
			['PHPFUI\\Input\\Hidden', 'hidden'],
			['PHPFUI\\Input\\Password', 'password'],
			['PHPFUI\\Input\\PasswordEye', 'password'],
			['PHPFUI\\Input\\Search', 'search'],
			['PHPFUI\\Input\\Text', 'text'],
			['PHPFUI\\Input\\Url', 'https://www.google.com'],
			//			['PHPFUI\\Input\\CheckBox', ''],
			//			['PHPFUI\\Input\\CheckBoxBoolean', ''],
			['PHPFUI\\Input\\Color', ''],
			['PHPFUI\\Input\\Hidden', ''],
			//			['PHPFUI\\Input\\Image', ''],
			['PHPFUI\\Input\\Month', ''],
			//			['PHPFUI\\Input\\MultiSelect', ''],
			['PHPFUI\\Input\\Number', '123'],
			//			['PHPFUI\\Input\\Radio', ''],
			//			['PHPFUI\\Input\\RadioGroup', ''],
			//			['PHPFUI\\Input\\Range', ''],
			['PHPFUI\\Input\\Select', ''],
			//			['PHPFUI\\Input\\SwitchCheckBox', '0'],
			//			['PHPFUI\\Input\\SwitchRadio', '1'],
		];
		}

  /**
   * @dataProvider providerPageInput
   */
	public function PageInputGroup(string $class) : void
		{
		$page = new \PHPFUI\Page();
		$page->setDebug(1);
		$inputGroup = new \PHPFUI\InputGroup();
		$input = new $class($page, $class, $class);
		$inputGroup->addInput($input);
		$inputGroup->addLabel('Label');

		if (\method_exists($input, 'setHint'))
			{
			$input->setHint('This is the hint');
			}

		if (\method_exists($input, 'setToolTip'))
			{
			$input->setToolTip('This is the tooltip');
			}

		if (\method_exists($input, 'addErrorMessage'))
			{
			$input->addErrorMessage('My error message');
			}
		$inputGroup->addButton(new \PHPFUI\Button('Button', '/link'));
		$page->add($inputGroup);
		$this->assertValidHtml($page);
		}

	/**
	 * @return array<int, array<string>>
	 */
	public static function providerPageInput() : array
		{
		return [
			['PHPFUI\\Input\\AutoComplete'],
			['PHPFUI\\Input\\Date'],
			['PHPFUI\\Input\\DateTime'],
			['PHPFUI\\Input\\File'],
			['PHPFUI\\Input\\LimitSelect'],
			['PHPFUI\\Input\\MonthYear'],
			['PHPFUI\\Input\\SelectAutoComplete'],
			['PHPFUI\\Input\\Tel'],
			['PHPFUI\\Input\\TextArea'],
			['PHPFUI\\Input\\Time'],
			['PHPFUI\\Input\\Zip'],
		];
		}
	}
