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

require_once 'bootstrap.php';

use Kevintweber\PhpunitMarkupValidators\Assert\AssertHtml5;

class HtmlTest extends \PHPUnit\Framework\TestCase
  {

  private $page;

  protected function setUp() : void
    {
    $this->page = new \PHPFUI\Page();
    }

  public function testAccordion()
    {
    $accordion = new \PHPFUI\Accordion();
    $accordion->addTab('Tab', 'Content');
    AssertHTML5::isValidMarkup($accordion);
    $this->page->add($accordion);
    }

  public function testAccordionMenu()
    {
    $accordianMenu = new \PHPFUI\AccordionMenu();
    AssertHTML5::isValidMarkup($accordianMenu);
    $this->page->add($accordianMenu);
    }

  public function testAccordionTabs()
    {
    $accordionTabs = new \PHPFUI\AccordionTabs($this->page);
    $accordionTabs->addTab('Tab', new \PHPFUI\Callout());
    AssertHTML5::isValidMarkup($accordionTabs);
    $this->page->add($accordionTabs);
    }

  public function testAccordionToFromList()
    {
    $accordionToFromList = new \PHPFUI\AccordionToFromList($this->page, 'fieldName', [], [], 'callbackIndex', function(){});
    AssertHTML5::isValidMarkup($accordionToFromList);
    $this->page->add($accordionToFromList);
    }

  public function testBadge()
    {
    $badge = new \PHPFUI\Badge('badge');
    AssertHTML5::isValidMarkup($badge);
    $this->page->add($badge);
    }

  public function testBlockGrid()
    {
    $blockGrid = new \PHPFUI\BlockGrid();
    AssertHTML5::isValidMarkup($blockGrid);
    $this->page->add($blockGrid);
    }

  public function testBreadCrumbs()
    {
    $crumbs = new \PHPFUI\BreadCrumbs();
    $crumbs->addCrumb('Crumb', '/Crumby');
    AssertHTML5::isValidMarkup($crumbs);
    $this->page->add($crumbs);
    }

  public function testButton()
    {
    $button = new \PHPFUI\Button('Click Me');
    AssertHTML5::isValidMarkup($button);
    $this->page->add($button);
    }

  public function testButtonGroup()
    {
    $buttonGroup = new \PHPFUI\ButtonGroup();
    $buttonGroup->addButton(new \PHPFUI\Button('Click Me'));
    AssertHTML5::isValidMarkup($buttonGroup);
    $this->page->add($buttonGroup);
    }

  public function testCallout()
    {
    $callout = new \PHPFUI\Callout();
    $callout->add('Call me out!');
    AssertHTML5::isValidMarkup($callout);
    $this->page->add($callout);
    }

  public function testCancel()
    {
    $cancel = new \PHPFUI\Cancel();
    AssertHTML5::isValidMarkup($cancel);
    $this->page->add($cancel);
    }

  public function testCard()
    {
    $card = new \PHPFUI\Card();
    $card->addSection('Section')->addDivider('Divider')->addImage(new \PHPFUI\Image('/image.png'));
    AssertHTML5::isValidMarkup($card);
    $this->page->add($card);
    }

  public function testCell()
    {
    $cell = new \PHPFUI\Cell();
    AssertHTML5::isValidMarkup($cell);
    $this->page->add($cell);
    }

  public function testCloseButton()
    {
    $closeButton = new \PHPFUI\CloseButton(new \PHPFUI\Button('Close Me'));
    AssertHTML5::isValidMarkup($closeButton);
    $this->page->add($closeButton);
    }

  public function testDisplay()
    {
    $display = new \PHPFUI\Display('label', 'text');
    AssertHTML5::isValidMarkup($display);
    $this->page->add($display);
    }

  public function testDrillDownMenu()
    {
    $drillDownMenu = new \PHPFUI\DrillDownMenu();
    AssertHTML5::isValidMarkup($drillDownMenu);
    $this->page->add($drillDownMenu);
    }

  public function testDropDown()
    {
    $dropDown = new \PHPFUI\DropDown(new \PHPFUI\Button('Click Me'), new \PHPFUI\Callout());
    AssertHTML5::isValidMarkup($dropDown);
    $this->page->add($dropDown);
    }

  public function testDropDownButton()
    {
    $dropDownButton = new \PHPFUI\DropDownButton('Button');
    AssertHTML5::isValidMarkup($dropDownButton);
    $this->page->add($dropDownButton);
    }

  public function testDropDownMenu()
    {
    $dropDownMenu = new \PHPFUI\DropDownMenu();
    AssertHTML5::isValidMarkup($dropDownMenu);
    $this->page->add($dropDownMenu);
    }

  public function testEmbed()
    {
    $embed = new \PHPFUI\Embed();
    AssertHTML5::isValidMarkup($embed);
    $this->page->add($embed);
    }

  public function testEqualizer()
    {
    $equalizer = new \PHPFUI\Equalizer();
    AssertHTML5::isValidMarkup($equalizer);
    $this->page->add($equalizer);
    }

  public function testFieldSet()
    {
    $fieldSet = new \PHPFUI\FieldSet();
    AssertHTML5::isValidMarkup($fieldSet);
    $this->page->add($fieldSet);
    }

  public function testForm()
    {
    $form = new \PHPFUI\Form($this->page);
    AssertHTML5::isValidMarkup($form);
    $this->page->add($form);
    }

  public function testFormError()
    {
    $formError = new \PHPFUI\FormError();
    AssertHTML5::isValidMarkup($formError);
    $this->page->add($formError);
    }

  public function testGridContainer()
    {
    $gridContainer = new \PHPFUI\GridContainer();
    AssertHTML5::isValidMarkup($gridContainer);
    $this->page->add($gridContainer);
    }

  public function testGridX()
    {
    $gridX = new \PHPFUI\GridX();
    AssertHTML5::isValidMarkup($gridX);
    $this->page->add($gridX);
    }

  public function testGridY()
    {
    $gridY = new \PHPFUI\GridY('100em');
    AssertHTML5::isValidMarkup($gridY);
    $this->page->add($gridY);
    }

  public function testHeader()
    {
    $header = new \PHPFUI\Header('Header');
    AssertHTML5::isValidMarkup($header);
    $this->page->add($header);
    }

  public function testHTML5Element()
    {
    $hTML5Element = new \PHPFUI\HTML5Element('div');
    $hTML5Element->add('Some text');
    AssertHTML5::isValidMarkup($hTML5Element);
    $this->page->add($hTML5Element);
    }

  public function testIcon()
    {
    $icon = new \PHPFUI\Icon('edit');
    AssertHTML5::isValidMarkup($icon);
    $this->page->add($icon);
    }

  public function testImage()
    {
    $image = new \PHPFUI\Image('/test.png');
    AssertHTML5::isValidMarkup($image);
    $this->page->add($image);
    }

  public function testInput()
    {
    $input = new \PHPFUI\Input('text', 'fred', 'Fred', 'Freddy');
    AssertHTML5::isValidMarkup($input);
    $this->page->add($input);
    }

  public function testInputGroup()
    {
    $inputGroup = new \PHPFUI\InputGroup();
    $inputGroup->addInput(new \PHPFUI\Input('text', 'fred', 'Fred', 'Freddy'));
    $inputGroup->addLabel('Label');
    $inputGroup->addButton(new \PHPFUI\Button('Button'));
    AssertHTML5::isValidMarkup($inputGroup);
    $this->page->add($inputGroup);
    }

  public function testLabel()
    {
    $label = new \PHPFUI\Label('Label');
    AssertHTML5::isValidMarkup($label);
    $this->page->add($label);
    }

  public function testLink()
    {
    $link = new \PHPFUI\Link('http://www.ibm.com', 'IBM');
    AssertHTML5::isValidMarkup($link);
    $this->page->add($link);
    }

  public function testMediaObject()
    {
    $mediaObject = new \PHPFUI\MediaObject();
    AssertHTML5::isValidMarkup($mediaObject);
    $this->page->add($mediaObject);
    }

  public function testMenu()
    {
    $menu = new \PHPFUI\Menu('Menu', '/Menu');
    AssertHTML5::isValidMarkup($menu);
    $this->page->add($menu);
    }

  public function testMultiColumn()
    {
    $multiColumn = new \PHPFUI\MultiColumn(new \PHPFUI\Link('http://www.ibm.com', 'IBM'), new \PHPFUI\Button('Go'));
    AssertHTML5::isValidMarkup($multiColumn);
    $this->page->add($multiColumn);
    }

  public function testOffCanvas()
    {
    $offCanvas = new \PHPFUI\OffCanvas(new \PHPFUI\Callout());
    AssertHTML5::isValidMarkup($offCanvas);
    $this->page->add($offCanvas);
    }

  public function testOrbit()
    {
    $orbit = new \PHPFUI\Orbit();
    $orbit->addHTMLSlide(new \PHPFUI\Callout('warning'), 'Warning Will Robinson', true);
    $orbit->addImageSlide(new \PHPFUI\Image('/lostInSpace.png'), 'Will Robinson', true);
    AssertHTML5::isValidMarkup($orbit);
    $this->page->add($orbit);
    }

  public function testOrderableTable()
    {
    $orderableTable = new \PHPFUI\OrderableTable($this->page);
    AssertHTML5::isValidMarkup($orderableTable);
    $this->page->add($orderableTable);
    }

  public function testOrderedList()
    {
    $orderedList = new \PHPFUI\OrderedList();
    $orderedList->addItem(new \PHPFUI\ListItem('Item', '/item'));
    AssertHTML5::isValidMarkup($orderedList);
    $this->page->add($orderedList);
    }

  public function testPagination()
    {
    $pagination = new \PHPFUI\Pagination(10, 100, '/paginate?page=PAGE');
    AssertHTML5::isValidMarkup($pagination);
    $this->page->add($pagination);
    }

  public function testPanel()
    {
    $panel = new \PHPFUI\Panel('Panel');
    AssertHTML5::isValidMarkup($panel);
    $this->page->add($panel);
    }

  public function testPayPalExpress()
    {
    $payPalExpress = new \PHPFUI\PayPalExpress($this->page, 'ClientId');
    AssertHTML5::isValidMarkup($payPalExpress);
    $this->page->add($payPalExpress);
    }

  public function testProgressBar()
    {
    $progressBar = new \PHPFUI\ProgressBar();
    $progressBar->setPercent(50);
    AssertHTML5::isValidMarkup($progressBar);
    $this->page->add($progressBar);
    }

  public function testRangeSlider()
    {
    $rangeSlider = new \PHPFUI\RangeSlider($this->page, 'name', new \PHPFUI\Input('text', 'value'));
    AssertHTML5::isValidMarkup($rangeSlider);
    $this->page->add($rangeSlider);
    }

  public function testReCAPTCHA()
    {
    $reCAPTCHA = new \PHPFUI\ReCAPTCHA($this->page, 'public', 'private');
    AssertHTML5::isValidMarkup($reCAPTCHA);
    $this->page->add($reCAPTCHA);
    }

  public function testReset()
    {
    $reset = new \PHPFUI\Reset();
    AssertHTML5::isValidMarkup($reset);
    $this->page->add($reset);
    }

  public function testReveal()
    {
    $reveal = new \PHPFUI\Reveal($this->page, new \PHPFUI\Button('Reveal Me'));
    AssertHTML5::isValidMarkup($reveal);
    $this->page->add($reveal);
    }

  public function testSlickSlider()
    {
    $slickSlider = new \PHPFUI\SlickSlider($this->page);
    $slickSlider->addImage('/test.png')->addSlide(new \PHPFUI\Header('Slide'));
    AssertHTML5::isValidMarkup($slickSlider);
    $this->page->add($slickSlider);
    }

  public function testSlider()
    {
    $slider = new \PHPFUI\Slider($this->page, 12);
    AssertHTML5::isValidMarkup($slider);
    $this->page->add($slider);
    }

  public function testSortableTable()
    {
    $sortableTable = new \PHPFUI\SortableTable();
    AssertHTML5::isValidMarkup($sortableTable);
    $this->page->add($sortableTable);
    }

  public function testSplitButton()
    {
    $splitButton = new \PHPFUI\SplitButton('Text', '/link');
    AssertHTML5::isValidMarkup($splitButton);
    $this->page->add($splitButton);
    }

  public function testSticky()
    {
    $sticky = new \PHPFUI\Sticky(new \PHPFUI\Callout());
    AssertHTML5::isValidMarkup($sticky);
    $this->page->add($sticky);
    }

  public function testSubHeader()
    {
    $subHeader = new \PHPFUI\SubHeader('Sub Header');
    AssertHTML5::isValidMarkup($subHeader);
    $this->page->add($subHeader);
    }

  public function testSubmit()
    {
    $submit = new \PHPFUI\Submit();
    AssertHTML5::isValidMarkup($submit);
    $this->page->add($submit);
    }

  public function testTable()
    {
    $table = new \PHPFUI\Table();
    AssertHTML5::isValidMarkup($table);
    $this->page->add($table);
    }

  public function testTabs()
    {
    $tabs = new \PHPFUI\Tabs();
    AssertHTML5::isValidMarkup($tabs);
    $this->page->add($tabs);
    }

  public function testThumbnail()
    {
    $thumbnail = new \PHPFUI\Thumbnail(new \PHPFUI\Image('/test.png'));
    AssertHTML5::isValidMarkup($thumbnail);
    $this->page->add($thumbnail);
    }

  public function testTitleBar()
    {
    $titleBar = new \PHPFUI\TitleBar();
    AssertHTML5::isValidMarkup($titleBar);
    $this->page->add($titleBar);
    }

  public function testToFromList()
    {
    $toFromList = new \PHPFUI\ToFromList($this->page, 'tofrom', [], [], 'index', function(){});
    AssertHTML5::isValidMarkup($toFromList);
    $this->page->add($toFromList);
    }

  public function testToolTip()
    {
    $toolTip = new \PHPFUI\ToolTip(new \PHPFUI\Button('Tip Me'), 'This is your tip');
    AssertHTML5::isValidMarkup($toolTip);
    $this->page->add($toolTip);
    }

  public function testTopBar()
    {
    $topBar = new \PHPFUI\TopBar();
    AssertHTML5::isValidMarkup($topBar);
    $this->page->add($topBar);
    }

  public function testUnorderedList()
    {
    $unorderedList = new \PHPFUI\UnorderedList();
    $unorderedList->addItem(new \PHPFUI\ListItem('Item', '/item'));
    AssertHTML5::isValidMarkup($unorderedList);
    $this->page->add($unorderedList);
    }

  public function testYouTube()
    {
    $youTube = new \PHPFUI\YouTube(123456789);
    AssertHTML5::isValidMarkup($youTube);
    $this->page->add($youTube);
    }

  public function testPage()
    {
    AssertHTML5::isValidMarkup($this->page);
    }

  }