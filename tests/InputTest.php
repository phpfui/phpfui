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

class InputTest extends \PHPFUI\HTMLUnitTester\Extensions
  {

  private $page;
  private $submit;
  private $form;

  public function setUp() : void
    {
    $this->page = new \PHPFUI\Page();
    $this->submit = new \PHPFUI\Submit();
    $this->form = new \PHPFUI\Form($this->page, $this->submit);
    }

  public function testAutoComplete()
    {
    $autoComplete = new \PHPFUI\Input\AutoComplete($this->page, function(){}, 'text', 'autoComplete', 'AutoComplete');
    $this->assertValidHtml($autoComplete);
    $this->form->add($autoComplete);
    }

  public function testCheckBox()
    {
    $checkBox = new \PHPFUI\Input\CheckBox('checkBox', 'CheckBox');
    $this->assertValidHtml($checkBox);
    $this->form->add($checkBox);
    }

  public function testCheckBoxBoolean()
    {
    $checkBoxBoolean = new \PHPFUI\Input\CheckBoxBoolean('checkBoxBoolean', 'CheckBoxBoolean');
    $this->assertValidHtml($checkBoxBoolean);
    $this->form->add($checkBoxBoolean);
    }

  public function testColor()
    {
    $color = new \PHPFUI\Input\Color('color', 'Color');
    $color->deleteAttribute('pattern'); // not valid html but foundation uses it
    $this->assertValidHtml($color);
    $this->form->add($color);
    }

  public function testDate()
    {
    $date = new \PHPFUI\Input\Date($this->page, 'date', 'Date');
    $this->assertValidHtml($date);
    $this->form->add($date);
    }

  public function testDateTime()
    {
    $dateTime = new \PHPFUI\Input\DateTime($this->page, 'dateTime', 'DateTime');
    $dateTime->deleteAttribute('pattern'); // not valid html but foundation uses it
    $this->assertValidHtml($dateTime);
    $this->form->add($dateTime);
    }

  public function testEmail()
    {
    $email = new \PHPFUI\Input\Email('email', 'Email');
    $this->assertValidHtml($email);
    $this->form->add($email);
    }

  public function testFile()
    {
    $file = new \PHPFUI\Input\File($this->page, 'file', 'File');
    $this->assertValidHtml($file);
    $this->form->add($file);
    }

  public function testHidden()
    {
    $hidden = new \PHPFUI\Input\Hidden('hidden', 'Hidden');
    $this->assertValidHtml($hidden);
    $this->form->add($hidden);
    }

  public function testImage()
    {
    $image = new \PHPFUI\Input\Image('image', 'Image');
    $this->assertValidHtml($image);
    $this->form->add($image);
    }

  public function testLimitSelect()
    {
    $limitSelect = new \PHPFUI\Input\LimitSelect($this->page, 50);
    $this->assertValidHtml($limitSelect);
    $this->form->add($limitSelect);
    }

  public function testMonth()
    {
    $month = new \PHPFUI\Input\Month('month', 'Month');
    $this->assertValidHtml($month);
    $this->form->add($month);
    }

  public function testMonthYear()
    {
    $monthYear = new \PHPFUI\Input\MonthYear($this->page, 'monthYear', 'MonthYear');
    $this->assertValidHtml($monthYear);
    $this->form->add($monthYear);
    }

  public function testMultiSelect()
    {
    $multiSelect = new \PHPFUI\Input\MultiSelect('multiSelect', 'MultiSelect');
    $this->assertValidHtml($multiSelect);
    $this->form->add($multiSelect);
    }

  public function testNumber()
    {
    $number = new \PHPFUI\Input\Number('number', 'Number');
    $this->assertValidHtml($number);
    $this->form->add($number);
    }

  public function testPassword()
    {
    $password = new \PHPFUI\Input\Password('password', 'Password');
    $this->assertValidHtml($password);
    $this->form->add($password);
    }

  public function testRadio()
    {
    $radio = new \PHPFUI\Input\Radio('radio', 'Radio');
    $this->assertValidHtml($radio);
    $this->form->add($radio);
    }

  public function testRadioGroup()
    {
    $radioGroup = new \PHPFUI\Input\RadioGroup('radioGroup', 'RadioGroup');
    $this->assertValidHtml($radioGroup);
    $this->form->add($radioGroup);
    }

  public function testRange()
    {
    $range = new \PHPFUI\Input\Range('range', 'Range');
    $this->assertValidHtml($range);
    $this->form->add($range);
    }

  public function testSearch()
    {
    $search = new \PHPFUI\Input\Search('search', 'Search');
    $this->assertValidHtml($search);
    $this->form->add($search);
    }

  public function testSelect()
    {
    $select = new \PHPFUI\Input\Select('select', 'Select');
    $this->assertValidHtml($select);
    $this->form->add($select);
    }

  public function testSelectAutoComplete()
    {
    $selectAutoComplete = new \PHPFUI\Input\SelectAutoComplete($this->page, 'selectAutoComplete', 'SelectAutoComplete', true);
    $this->assertValidHtml($selectAutoComplete);
    $this->form->add($selectAutoComplete);
    }

  public function testSwitchCheckBox()
    {
    $switchCheckBox = new \PHPFUI\Input\SwitchCheckBox('switchCheckBox', 'SwitchCheckBox');
    $this->assertValidHtml($switchCheckBox);
    $this->form->add($switchCheckBox);
    }

  public function testSwitchRadio()
    {
    $switchRadio = new \PHPFUI\Input\SwitchRadio('switchRadio', 'SwitchRadio');
    $this->assertValidHtml($switchRadio);
    $this->form->add($switchRadio);
    }

  public function testTel()
    {
    $tel = new \PHPFUI\Input\Tel('tel', 'Tel');
    $this->assertValidHtml($tel);
    $this->form->add($tel);
    }

  public function testText()
    {
    $text = new \PHPFUI\Input\Text('text', 'Text');
    $this->assertValidHtml($text);
    $this->form->add($text);
    }

  public function testTextArea()
    {
    $textArea = new \PHPFUI\Input\TextArea('textArea', 'TextArea');
    $this->assertValidHtml($textArea);
    $this->form->add($textArea);
    }

  public function testTime()
    {
    $time = new \PHPFUI\Input\Time($this->page, 'time', 'Time');
    $this->assertValidHtml($time);
    $this->form->add($time);
    }

  public function testUrl()
    {
    $url = new \PHPFUI\Input\Url('url', 'Url');
    $this->assertValidHtml($url);
    $this->form->add($url);
    }

  public function testWeek()
    {
    $week = new \PHPFUI\Input\Week('week', 'Week');
    $this->assertValidHtml($week);
    $this->form->add($week);
    }

  public function testZip()
    {
    $zip = new \PHPFUI\Input\Zip($this->page, 'zip', 'Zip');
    $this->assertValidHtml($zip);
    $this->form->add($zip);
    }

  public function testPage()
    {
    $this->form->add($this->submit);
    $this->assertValidHtml($this->page);
    }

  }