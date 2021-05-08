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
 * Cancel
 * Cell
 * FieldSet
 * Form
 * FormError
 * FroalaModel
 * HTMLList
 * Icon
 * InputGroup
 * Link
 * MediaObject
 * OffCanvas
 * OrderableTable
 * Panel
 * PopupInput
 * RadioTable
 * RadioTableCell
 * Reset
 * SortableTable
 * Sticky
 * Tabs
 * TimedCellUpdate *
 *
 */
class InputTest extends \PHPFUI\HTMLUnitTester\Extensions
	{
	private $page;

	public function setUp() : void
		{
		$this->page = new \PHPFUI\Page();
		$this->page->setDebug(\PHPFUI\Base::DEBUG_SOURCE);
		}

	public function testAutoComplete() : void
		{
		$autoComplete = new \PHPFUI\Input\AutoComplete($this->page, static function() : void {}, 'text', 'autoComplete', 'AutoComplete');
		$this->page->add($autoComplete);
		$this->assertValidHtml($this->page);
		}

	public function testCheckBox() : void
		{
		$checkBox = new \PHPFUI\Input\CheckBox('checkBox', 'CheckBox');
		$this->assertFalse($checkBox->getChecked());
		$checkBox->setChecked();
		$this->assertTrue($checkBox->getChecked());
		$this->page->add($checkBox);
		$this->assertValidHtml($this->page);
		}

	public function testCheckBoxBoolean() : void
		{
		$checkBoxBoolean = new \PHPFUI\Input\CheckBoxBoolean('checkBoxBoolean', 'CheckBoxBoolean');
		$this->assertFalse($checkBoxBoolean->getChecked());
		$checkBoxBoolean->setChecked();
		$this->assertTrue($checkBoxBoolean->getChecked());
		$this->page->add($checkBoxBoolean);
		$this->assertValidHtml($this->page);
		}

	public function testCheckBoxGroup() : void
		{
		$checkBoxes = new \PHPFUI\CheckBoxGroup('Check these out');

		for ($i = 1; $i <= 3; ++$i)
			{
			$field = 'CB' . $i;
			$checkBoxes->addCheckBox(new \PHPFUI\Input\CheckBoxBoolean($field, 'Checkbox ' . $i));
			}
		$this->page->add($checkBoxes);
		$this->assertValidHtml($this->page);
		}

	public function testColor() : void
		{
		$color = new \PHPFUI\Input\Color('color', 'Color');
		$color->deleteAttribute('pattern'); // not valid html but foundation uses it
		$color->setRequired();
		$this->page->add($color);
		$this->assertValidHtml($this->page);
		}

	public function testDate() : void
		{
		$date = new \PHPFUI\Input\Date($this->page, 'date', 'Date');
		$date->setRequired();
		$this->page->add($date);
		$this->assertValidHtml($this->page);
		}

	public function testDateTime() : void
		{
		$dateTime = new \PHPFUI\Input\DateTime($this->page, 'dateTime', 'DateTime');
		$dateTime->deleteAttribute('pattern'); // not valid html but foundation uses it
		$dateTime->setRequired();
		$this->page->add($dateTime);
		$this->assertValidHtml($this->page);
		}

	public function testEmail() : void
		{
		$email = new \PHPFUI\Input\Email('email', 'Email');
		$email->setRequired();
		$this->page->add($email);
		$this->assertValidHtml($this->page);
		}

	public function testFile() : void
		{
		$file = new \PHPFUI\Input\File($this->page, 'file', 'File');
		$file->setAllowedExtensions(['jpg', 'png', 'jpeg']);
		$this->page->add($file);
		$this->assertValidHtml($this->page);
		}

	public function testHidden() : void
		{
		$hidden = new \PHPFUI\Input\Hidden('hidden', 'Hidden');
		$this->page->add($hidden);
		$this->assertValidHtml($this->page);
		}

	public function testImage() : void
		{
		$image = new \PHPFUI\Input\Image('image', 'Image');
		$this->page->add($image);
		$this->assertValidHtml($this->page);
		}

	public function testLimitSelect() : void
		{
		$limitSelect = new \PHPFUI\Input\LimitSelect($this->page, 50);
		$this->page->add($limitSelect);
		$this->assertValidHtml($this->page);
		}

	public function testMonth() : void
		{
		$month = new \PHPFUI\Input\Month('month', 'Month');
		$this->page->add($month);
		$this->assertValidHtml($this->page);
		}

	public function testMonthYear() : void
		{
		$monthYear = new \PHPFUI\Input\MonthYear($this->page, 'monthYear', 'MonthYear');
		$monthYear->setMinYear(2000);
		$monthYear->setMaxYear(2010);
		$this->page->add($monthYear);
		$this->assertValidHtml($this->page);
		}

	public function testMultiSelect() : void
		{
		$multiSelect = new \PHPFUI\Input\MultiSelect('multiSelect', 'MultiSelect');
		$multiSelect->selectAll();
		$multiSelect->setColumns(2);

		$multiSelect->addOption('');
		$multiSelect->addOption('one');
		$multiSelect->addOption('two', 2, true);
		$multiSelect->addOption('three', 3, true);
		$multiSelect->addOption('four', 4, false, true);
		$this->assertEquals($multiSelect->count(), 5);
		$this->assertEquals(count($multiSelect), 5);
		$this->page->add($multiSelect);
		$this->assertValidHtml($this->page);
		}

	public function testMultiSelectNoLabel() : void
		{
		$multiSelect = new \PHPFUI\Input\MultiSelect('multiSelect');
		$multiSelect->selectAll();
		$multiSelect->setColumns(2);

		$multiSelect->addOption('');
		$multiSelect->addOption('one');
		$multiSelect->addOption('two', 2, true);
		$multiSelect->addOption('three', 3, true);
		$multiSelect->addOption('four', 4, false, true);
		$this->assertEquals($multiSelect->count(), 5);
		$this->assertEquals(count($multiSelect), 5);
		$this->page->add($multiSelect);
		$this->assertValidHtml($this->page);
		}

	public function testNumber() : void
		{
		$number = new \PHPFUI\Input\Number('number', 'Number');
		$number->setRequired();
		$this->page->add($number);
		$this->assertValidHtml($this->page);
		}

	public function testPassword() : void
		{
		$password = new \PHPFUI\Input\Password('password', 'Password');
		$password->setRequired();
		$this->page->add($password);
		$this->assertValidHtml($this->page);
		}

	public function testPasswordEye() : void
		{
		$password = new \PHPFUI\Input\PasswordEye('password', 'Password');
		$password->setToolTip('Click the eye icon on the right to show the password');
		$password->setRequired();
		$this->page->add($password);
		$this->assertValidHtml($this->page);
		}

	public function testRadio() : void
		{
		$radio = new \PHPFUI\Input\Radio('radio', 'Radio');
		$radio->setChecked();
		$radio->setRequired();
		$this->page->add($radio);
		$this->assertValidHtml($this->page);
		}

	public function testRadioNoLabel() : void
		{
		$radio = new \PHPFUI\Input\Radio('radio');
		$radio->setChecked();
		$this->page->add($radio);
		$this->assertValidHtml($this->page);
		}

	public function testRadioGroup() : void
		{
		$radioGroup = new \PHPFUI\Input\RadioGroup('radioGroup', 'RadioGroup', 4);
		$radioGroup->addButton('');
		$radioGroup->addButton('one');
		$radioGroup->addButton('two', 2);
		$radioGroup->addButton('three', 3, true);
		$radioGroup->addButton('four', 4);
		$radioGroup->setRequired();
		$this->assertEquals($radioGroup->count(), 5);
		$this->assertEquals(count($radioGroup), 5);

		$this->page->add($radioGroup);
		$this->assertValidHtml($this->page);
		}

	public function testRadioGroupNoLabel() : void
		{
		$radioGroup = new \PHPFUI\Input\RadioGroup('radioGroup', '', 4);
		$radioGroup->addButton('');
		$radioGroup->addButton('one');
		$radioGroup->addButton('two', 2);
		$radioGroup->addButton('three', 3, true);
		$radioGroup->addButton('four', 4);
		$this->assertEquals($radioGroup->count(), 5);
		$this->assertEquals(count($radioGroup), 5);

		$this->page->add($radioGroup);
		$this->assertValidHtml($this->page);
		}

	public function testRange() : void
		{
		$range = new \PHPFUI\Input\Range('range', 'Range');
		$this->page->add($range);
		$this->assertValidHtml($this->page);
		}

	public function testRangeNoLabel() : void
		{
		$range = new \PHPFUI\Input\Range('range');
		$this->page->add($range);
		$this->assertValidHtml($this->page);
		}

	public function testSearch() : void
		{
		$search = new \PHPFUI\Input\Search('search', 'Search');
		$this->page->add($search);
		$this->assertValidHtml($this->page);
		}

	public function testSearchNoLabel() : void
		{
		$search = new \PHPFUI\Input\Search('search');
		$this->page->add($search);
		$this->assertValidHtml($this->page);
		}

	public function testSelect() : void
		{
		$select = new \PHPFUI\Input\Select('select', 'Select');
		$select->addLabelClass('test');

		$select->addOption('');
		$select->addOption('one');
		$select->addOption('two', 2);
		$select->addOption('three', 3, true);
		$select->addOption('four', 4, false, true);

		$optGroup = new \PHPFUI\Input\OptGroup('Option Group');
		$optGroup->addOption('');
		$optGroup->addOption('one');
		$optGroup->addOption('two', 2);
		$optGroup->addOption('three', 3);
		$optGroup->addOption('four', 4, false, true);
		$this->assertEquals($optGroup->count(), 5);
		$this->assertEquals(count($optGroup), 5);

		$select->addOptGroup($optGroup);
		$this->assertEquals($select->count(), 6);
		$this->assertEquals(count($select), 6);
		$this->page->add($select);
		$this->assertValidHtml($this->page);
		}

	public function testSelectNoLabel() : void
		{
		$select = new \PHPFUI\Input\Select('select');
		$select->setRequired();
		$select->addLabelClass('test');

		$select->addOption('');
		$select->addOption('one');
		$select->addOption('two', 2);
		$select->addOption('three', 3, true);
		$select->addOption('four', 4, false, true);

		$optGroup = new \PHPFUI\Input\OptGroup('Option Group');
		$optGroup->addOption('');
		$optGroup->addOption('one');
		$optGroup->addOption('two', 2);
		$optGroup->addOption('three', 3);
		$optGroup->addOption('four', 4, false, true);
		$this->assertEquals($optGroup->count(), 5);
		$this->assertEquals(\count($optGroup), 5);

		$select->addOptGroup($optGroup);
		$this->assertEquals($select->count(), 6);
		$this->assertEquals(count($select), 6);
		$this->page->add($select);
		$this->assertValidHtml($this->page);
		}

	public function testSelectAutoComplete() : void
		{
		$select = new \PHPFUI\Input\SelectAutoComplete($this->page, 'selectAutoComplete', 'SelectAutoComplete', true);
		$select->addLabelClass('test');

		$select->addOption('');
		$select->addOption('one');
		$select->addOption('two', 2);
		$select->addOption('three', 3, true);
		$select->addOption('four', 4, false, true);

		$this->assertEquals($select->count(), 5);
		$this->assertEquals(count($select), 5);
		$this->page->add($select);
		$this->assertValidHtml($this->page);
		}

	public function testSelectAutoCompleteNoLabel() : void
		{
		$select = new \PHPFUI\Input\SelectAutoComplete($this->page, 'selectAutoComplete');
		$select->addLabelClass('test');

		$select->addOption('');
		$select->addOption('one');
		$select->addOption('two', 2);
		$select->addOption('three', 3, true);
		$select->addOption('four', 4, false, true);

		$this->assertEquals($select->count(), 5);
		$this->assertEquals(count($select), 5);
		$this->page->add($select);
		$this->assertValidHtml($this->page);
		}

	public function testSwitchCheckBox() : void
		{
		$switchCheckBox = new \PHPFUI\Input\SwitchCheckBox('switchCheckBox', 'SwitchCheckBox');
		$switchCheckBox->setChecked();
		$this->page->add($switchCheckBox);
		$this->assertValidHtml($this->page);
		}

	public function testSwitchRadio() : void
		{
		$switchRadio = new \PHPFUI\Input\SwitchRadio('switchRadio', 'SwitchRadio');
		$switchRadio->setChecked();
		$switchRadio->setActiveLabel('on');
		$switchRadio->setInactiveLabel('off');
		$this->page->add($switchRadio);
		$this->assertValidHtml($this->page);
		}

	public function testTel() : void
		{
		$tel = new \PHPFUI\Input\Tel($this->page, 'tel', 'Tel');
		$tel->setRequired();
		$this->page->add($tel);
		$this->assertValidHtml($this->page);
		}

	public function testText() : void
		{
		$text = new \PHPFUI\Input\Text('text', 'Text');
		$this->page->add($text);
		$this->assertValidHtml($this->page);
		}

	public function testTextArea() : void
		{
		$textArea = new \PHPFUI\Input\TextArea('textArea', 'TextArea');
		$textArea->setRows(3);
		$this->page->add($textArea);
		$this->assertValidHtml($this->page);
		}

	public function testTextAreaNoLabel() : void
		{
		$textArea = new \PHPFUI\Input\TextArea('textArea');
		$textArea->setRequired();
		$textArea->setRows(3);
		$this->page->add($textArea);
		$this->assertValidHtml($this->page);
		}

	public function testTime() : void
		{
		$time = new \PHPFUI\Input\Time($this->page, 'time', 'Time');
		$time->setRequired();
		$this->page->add($time);
		$this->assertValidHtml($this->page);
		}

	public function testUrl() : void
		{
		$url = new \PHPFUI\Input\Url('url', 'Url');
		$url->setRequired();
		$this->page->add($url);
		$this->assertValidHtml($this->page);
		}

	public function testWeek() : void
		{
		$week = new \PHPFUI\Input\Week('week', 'Week');
		$week->setRequired();
		$this->page->add($week);
		$this->assertValidHtml($this->page);
		}

	public function testZip() : void
		{
		$zip = new \PHPFUI\Input\Zip($this->page, 'zip', 'Zip');
		$zip->setRequired();
		$this->page->add($zip);
		$this->assertValidHtml($this->page);
		}
	}
