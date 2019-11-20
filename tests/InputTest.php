<?php

/**
 * This file is part of the PHPFUI package
 *
 * (c) Bruce Wells
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source
 * code
 *
Cancel
Cell
FieldSet
Form
FormError
FroalaModel
HTMLList
Icon
InputGroup
Link
MediaObject
OffCanvas
OrderableTable
Panel
PopupInput
RadioTable
RadioTableCell
Reset
SortableTable
Sticky
Tabs
TimedCellUpdate *
 *
 */
class InputTest extends \PHPFUI\HTMLUnitTester\Extensions
	{
	private $form;

	private $page;
	private $submit;

	public function setUp() : void
		{
		$this->page = new \PHPFUI\Page();
		$this->submit = new \PHPFUI\Submit();
		$this->form = new \PHPFUI\Form($this->page, $this->submit);
		}

	public function testAutoComplete() : void
		{
		$autoComplete = new \PHPFUI\Input\AutoComplete($this->page, function() : void{}, 'text', 'autoComplete', 'AutoComplete');
		$this->assertValidHtml($autoComplete);
		$this->form->add($autoComplete);
		}

	public function testCheckBox() : void
		{
		$checkBox = new \PHPFUI\Input\CheckBox('checkBox', 'CheckBox');
		$this->assertValidHtml($checkBox);
		$this->form->add($checkBox);
		}

	public function testCheckBoxBoolean() : void
		{
		$checkBoxBoolean = new \PHPFUI\Input\CheckBoxBoolean('checkBoxBoolean', 'CheckBoxBoolean');
		$this->assertValidHtml($checkBoxBoolean);
		$this->form->add($checkBoxBoolean);
		}

	public function testColor() : void
		{
		$color = new \PHPFUI\Input\Color('color', 'Color');
		$color->deleteAttribute('pattern'); // not valid html but foundation uses it
		$this->assertValidHtml($color);
		$this->form->add($color);
		}

	public function testDate() : void
		{
		$date = new \PHPFUI\Input\Date($this->page, 'date', 'Date');
		$this->assertValidHtml($date);
		$this->form->add($date);
		}

	public function testDateTime() : void
		{
		$dateTime = new \PHPFUI\Input\DateTime($this->page, 'dateTime', 'DateTime');
		$dateTime->deleteAttribute('pattern'); // not valid html but foundation uses it
		$this->assertValidHtml($dateTime);
		$this->form->add($dateTime);
		}

	public function testEmail() : void
		{
		$email = new \PHPFUI\Input\Email('email', 'Email');
		$this->assertValidHtml($email);
		$this->form->add($email);
		}

	public function testFile() : void
		{
		$file = new \PHPFUI\Input\File($this->page, 'file', 'File');
		$file->setAllowedExtensions(['jpg', 'png', 'jpeg']);
		$this->assertValidHtml($file);
		$this->form->add($file);
		}

	public function testHidden() : void
		{
		$hidden = new \PHPFUI\Input\Hidden('hidden', 'Hidden');
		$this->assertValidHtml($hidden);
		$this->form->add($hidden);
		}

	public function testImage() : void
		{
		$image = new \PHPFUI\Input\Image('image', 'Image');
		$this->assertValidHtml($image);
		$this->form->add($image);
		}

	public function testLimitSelect() : void
		{
		$limitSelect = new \PHPFUI\Input\LimitSelect($this->page, 50);
		$this->assertValidHtml($limitSelect);
		$this->form->add($limitSelect);
		}

	public function testMonth() : void
		{
		$month = new \PHPFUI\Input\Month('month', 'Month');
		$this->assertValidHtml($month);
		$this->form->add($month);
		}

	public function testMonthYear() : void
		{
		$monthYear = new \PHPFUI\Input\MonthYear($this->page, 'monthYear', 'MonthYear');
		$this->assertValidHtml($monthYear);
		$this->form->add($monthYear);
		}

	public function testMultiSelect() : void
		{
		$multiSelect = new \PHPFUI\Input\MultiSelect('multiSelect', 'MultiSelect');
		$this->assertValidHtml($multiSelect);
		$this->form->add($multiSelect);
		}

	public function testNumber() : void
		{
		$number = new \PHPFUI\Input\Number('number', 'Number');
		$this->assertValidHtml($number);
		$this->form->add($number);
		}

	public function testPage() : void
		{
		$this->form->add($this->submit);
		$this->assertValidHtml($this->page);
		}

	public function testPassword() : void
		{
		$password = new \PHPFUI\Input\Password('password', 'Password');
		$this->assertValidHtml($password);
		$this->form->add($password);
		}

	public function testRadio() : void
		{
		$radio = new \PHPFUI\Input\Radio('radio', 'Radio');
		$this->assertValidHtml($radio);
		$this->form->add($radio);
		}

	public function testRadioGroup() : void
		{
		$radioGroup = new \PHPFUI\Input\RadioGroup('radioGroup', 'RadioGroup');
		$this->assertValidHtml($radioGroup);
		$this->form->add($radioGroup);
		}

	public function testRange() : void
		{
		$range = new \PHPFUI\Input\Range('range', 'Range');
		$this->assertValidHtml($range);
		$this->form->add($range);
		}

	public function testSearch() : void
		{
		$search = new \PHPFUI\Input\Search('search', 'Search');
		$this->assertValidHtml($search);
		$this->form->add($search);
		}

	public function testSelect() : void
		{
		$select = new \PHPFUI\Input\Select('select', 'Select');
		$this->assertValidHtml($select);
		$this->form->add($select);
		}

	public function testSelectAutoComplete() : void
		{
		$selectAutoComplete = new \PHPFUI\Input\SelectAutoComplete($this->page, 'selectAutoComplete', 'SelectAutoComplete', true);
		$this->assertValidHtml($selectAutoComplete);
		$this->form->add($selectAutoComplete);
		}

	public function testSwitchCheckBox() : void
		{
		$switchCheckBox = new \PHPFUI\Input\SwitchCheckBox('switchCheckBox', 'SwitchCheckBox');
		$this->assertValidHtml($switchCheckBox);
		$this->form->add($switchCheckBox);
		}

	public function testSwitchRadio() : void
		{
		$switchRadio = new \PHPFUI\Input\SwitchRadio('switchRadio', 'SwitchRadio');
		$this->assertValidHtml($switchRadio);
		$this->form->add($switchRadio);
		}

	public function testTel() : void
		{
		$tel = new \PHPFUI\Input\Tel($this->page, 'tel', 'Tel');
		$this->assertValidHtml($tel);
		$this->form->add($tel);
		}

	public function testText() : void
		{
		$text = new \PHPFUI\Input\Text('text', 'Text');
		$this->assertValidHtml($text);
		$this->form->add($text);
		}

	public function testTextArea() : void
		{
		$textArea = new \PHPFUI\Input\TextArea('textArea', 'TextArea');
		$this->assertValidHtml($textArea);
		$this->form->add($textArea);
		}

	public function testTime() : void
		{
		$time = new \PHPFUI\Input\Time($this->page, 'time', 'Time');
		$this->assertValidHtml($time);
		$this->form->add($time);
		}

	public function testUrl() : void
		{
		$url = new \PHPFUI\Input\Url('url', 'Url');
		$this->assertValidHtml($url);
		$this->form->add($url);
		}

	public function testWeek() : void
		{
		$week = new \PHPFUI\Input\Week('week', 'Week');
		$this->assertValidHtml($week);
		$this->form->add($week);
		}

	public function testZip() : void
		{
		$zip = new \PHPFUI\Input\Zip($this->page, 'zip', 'Zip');
		$this->assertValidHtml($zip);
		$this->form->add($zip);
		}
	}
