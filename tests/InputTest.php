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

use Kevintweber\PhpunitMarkupValidators\Assert\AssertHtml5;

class InputTest extends \PHPUnit\Framework\TestCase
  {

  private $page;
  private $submit;
  private $form;

  protected function setUp() : void
    {
    $this->page = new \PHPFUI\Page();
    $this->submit = new \PHPFUI\Submit();
    $this->form = new \PHPFUI\Form($this->page, $this->submit);
    }

  public function testAutoComplete()
    {
    $autoComplete = new \PHPFUI\Input\AutoComplete($this->page, function(){}, 'text', 'autoComplete', 'AutoComplete');
    AssertHTML5::isValidMarkup($autoComplete);
    $this->form->add($autoComplete);
    }

  public function testCheckBox()
    {
    $checkBox = new \PHPFUI\Input\CheckBox('checkBox', 'CheckBox');
    AssertHTML5::isValidMarkup($checkBox);
    $this->form->add($checkBox);
    }

  public function testCheckBoxBoolean()
    {
    $checkBoxBoolean = new \PHPFUI\Input\CheckBoxBoolean('checkBoxBoolean', 'CheckBoxBoolean');
    AssertHTML5::isValidMarkup($checkBoxBoolean);
    $this->form->add($checkBoxBoolean);
    }

  public function testColor()
    {
    $color = new \PHPFUI\Input\Color('color', 'Color');
    $color->deleteAttribute('pattern'); // not valid html but foundation uses it
    AssertHTML5::isValidMarkup($color);
    $this->form->add($color);
    }

  public function testDate()
    {
    $date = new \PHPFUI\Input\Date($this->page, 'date', 'Date');
    AssertHTML5::isValidMarkup($date);
    $this->form->add($date);
    }

  public function testDateTime()
    {
    $dateTime = new \PHPFUI\Input\DateTime($this->page, 'dateTime', 'DateTime');
    $dateTime->deleteAttribute('pattern'); // not valid html but foundation uses it
    AssertHTML5::isValidMarkup($dateTime);
    $this->form->add($dateTime);
    }

  public function testEmail()
    {
    $email = new \PHPFUI\Input\Email('email', 'Email');
    AssertHTML5::isValidMarkup($email);
    $this->form->add($email);
    }

  public function testFile()
    {
    $file = new \PHPFUI\Input\File($this->page, 'file', 'File');
    AssertHTML5::isValidMarkup($file);
    $this->form->add($file);
    }

  public function testHidden()
    {
    $hidden = new \PHPFUI\Input\Hidden('hidden', 'Hidden');
    AssertHTML5::isValidMarkup($hidden);
    $this->form->add($hidden);
    }

  public function testImage()
    {
    $image = new \PHPFUI\Input\Image('image', 'Image');
    AssertHTML5::isValidMarkup($image);
    $this->form->add($image);
    }

  public function testLimitSelect()
    {
    $limitSelect = new \PHPFUI\Input\LimitSelect($this->page, 50);
    AssertHTML5::isValidMarkup($limitSelect);
    $this->form->add($limitSelect);
    }

  public function testMonth()
    {
    $month = new \PHPFUI\Input\Month('month', 'Month');
    AssertHTML5::isValidMarkup($month);
    $this->form->add($month);
    }

  public function testMonthYear()
    {
    $monthYear = new \PHPFUI\Input\MonthYear($this->page, 'monthYear', 'MonthYear');
    AssertHTML5::isValidMarkup($monthYear);
    $this->form->add($monthYear);
    }

  public function testMultiSelect()
    {
    $multiSelect = new \PHPFUI\Input\MultiSelect('multiSelect', 'MultiSelect');
    AssertHTML5::isValidMarkup($multiSelect);
    $this->form->add($multiSelect);
    }

  public function testNumber()
    {
    $number = new \PHPFUI\Input\Number('number', 'Number');
    AssertHTML5::isValidMarkup($number);
    $this->form->add($number);
    }

  public function testPassword()
    {
    $password = new \PHPFUI\Input\Password('password', 'Password');
    AssertHTML5::isValidMarkup($password);
    $this->form->add($password);
    }

  public function testRadio()
    {
    $radio = new \PHPFUI\Input\Radio('radio', 'Radio');
    AssertHTML5::isValidMarkup($radio);
    $this->form->add($radio);
    }

  public function testRadioGroup()
    {
    $radioGroup = new \PHPFUI\Input\RadioGroup('radioGroup', 'RadioGroup');
    AssertHTML5::isValidMarkup($radioGroup);
    $this->form->add($radioGroup);
    }

  public function testRange()
    {
    $range = new \PHPFUI\Input\Range('range', 'Range');
    AssertHTML5::isValidMarkup($range);
    $this->form->add($range);
    }

  public function testSearch()
    {
    $search = new \PHPFUI\Input\Search('search', 'Search');
    AssertHTML5::isValidMarkup($search);
    $this->form->add($search);
    }

  public function testSelect()
    {
    $select = new \PHPFUI\Input\Select('select', 'Select');
    AssertHTML5::isValidMarkup($select);
    $this->form->add($select);
    }

  public function testSelectAutoComplete()
    {
    $selectAutoComplete = new \PHPFUI\Input\SelectAutoComplete($this->page, 'selectAutoComplete', 'SelectAutoComplete', true);
    AssertHTML5::isValidMarkup($selectAutoComplete);
    $this->form->add($selectAutoComplete);
    }

  public function testSwitchCheckBox()
    {
    $switchCheckBox = new \PHPFUI\Input\SwitchCheckBox('switchCheckBox', 'SwitchCheckBox');
    AssertHTML5::isValidMarkup($switchCheckBox);
    $this->form->add($switchCheckBox);
    }

  public function testSwitchRadio()
    {
    $switchRadio = new \PHPFUI\Input\SwitchRadio('switchRadio', 'SwitchRadio');
    AssertHTML5::isValidMarkup($switchRadio);
    $this->form->add($switchRadio);
    }

  public function testTel()
    {
    $tel = new \PHPFUI\Input\Tel('tel', 'Tel');
    AssertHTML5::isValidMarkup($tel);
    $this->form->add($tel);
    }

  public function testText()
    {
    $text = new \PHPFUI\Input\Text('text', 'Text');
    AssertHTML5::isValidMarkup($text);
    $this->form->add($text);
    }

  public function testTextArea()
    {
    $textArea = new \PHPFUI\Input\TextArea('textArea', 'TextArea');
    AssertHTML5::isValidMarkup($textArea);
    $this->form->add($textArea);
    }

  public function testTime()
    {
    $time = new \PHPFUI\Input\Time($this->page, 'time', 'Time');
    AssertHTML5::isValidMarkup($time);
    $this->form->add($time);
    }

  public function testUrl()
    {
    $url = new \PHPFUI\Input\Url('url', 'Url');
    AssertHTML5::isValidMarkup($url);
    $this->form->add($url);
    }

  public function testWeek()
    {
    $week = new \PHPFUI\Input\Week('week', 'Week');
    AssertHTML5::isValidMarkup($week);
    $this->form->add($week);
    }

  public function testZip()
    {
    $zip = new \PHPFUI\Input\Zip($this->page, 'zip', 'Zip');
    AssertHTML5::isValidMarkup($zip);
    $this->form->add($zip);
    }

  public function testPage()
    {
    $this->form->add($this->submit);
    AssertHTML5::isValidMarkup($this->page);
    }

  }