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

class HtmlTest extends \PHPFUI\HTMLUnitTester\Extensions
  {

  private $page;

  public function setUp() : void
    {
    $this->page = new \PHPFUI\Page();
    }

  public function testAccordion()
    {
    $accordion = new \PHPFUI\Accordion();
    $accordion->addTab('Tab', 'Content');
    $this->assertValidHtml($accordion);
    $this->page->add($accordion);
    }

  public function testAccordionMenu()
    {
    $accordianMenu = new \PHPFUI\AccordionMenu();
    $this->assertValidHtml($accordianMenu);
    $this->page->add($accordianMenu);
    }

  public function testAccordionTabs()
    {
    $accordionTabs = new \PHPFUI\AccordionTabs($this->page);
    $accordionTabs->addTab('Tab', new \PHPFUI\Callout());
    $this->assertValidHtml($accordionTabs);
    $this->page->add($accordionTabs);
    }

  public function testAccordionToFromList()
    {
    $accordionToFromList = new \PHPFUI\AccordionToFromList($this->page, 'fieldName', [], [], 'callbackIndex', function(){});
    $this->assertValidHtml($accordionToFromList);
    $this->page->add($accordionToFromList);
    }

  public function testBadge()
    {
    $badge = new \PHPFUI\Badge('badge');
    $this->assertValidHtml($badge);
    $this->page->add($badge);
    }

  public function testBlockGrid()
    {
    $blockGrid = new \PHPFUI\BlockGrid();
    $this->assertValidHtml($blockGrid);
    $this->page->add($blockGrid);
    }

  public function testBreadCrumbs()
    {
    $crumbs = new \PHPFUI\BreadCrumbs();
    $crumbs->addCrumb('Crumb', '/Crumby');
    $this->assertValidHtml($crumbs);
    $this->page->add($crumbs);
    }

  public function testButton()
    {
    $button = new \PHPFUI\Button('Click Me');
    $this->assertValidHtml($button);
    $this->page->add($button);
    }

  public function testButtonGroup()
    {
    $buttonGroup = new \PHPFUI\ButtonGroup();
    $buttonGroup->addButton(new \PHPFUI\Button('Click Me'));
    $this->assertValidHtml($buttonGroup);
    $this->page->add($buttonGroup);
    }

  public function testCallout()
    {
    $callout = new \PHPFUI\Callout();
    $callout->add('Call me out!');
    $this->assertValidHtml($callout);
    $this->page->add($callout);
    }

  public function testCancel()
    {
    $cancel = new \PHPFUI\Cancel();
    $this->assertValidHtml($cancel);
    $this->page->add($cancel);
    }

  public function testCard()
    {
    $card = new \PHPFUI\Card();
    $card->addSection('Section')->addDivider('Divider')->addImage(new \PHPFUI\Image('/image.png'));
    $this->assertValidHtml($card);
    $this->page->add($card);
    }

  public function testCell()
    {
    $cell = new \PHPFUI\Cell();
    $this->assertValidHtml($cell);
    $this->page->add($cell);
    }

  public function testCloseButton()
    {
    $closeButton = new \PHPFUI\CloseButton(new \PHPFUI\Button('Close Me'));
    $this->assertValidHtml($closeButton);
    $this->page->add($closeButton);
    }

  public function testDisplay()
    {
    $display = new \PHPFUI\Display('label', 'text');
    $this->assertValidHtml($display);
    $this->page->add($display);
    }

  public function testDrillDownMenu()
    {
    $drillDownMenu = new \PHPFUI\DrillDownMenu();
    $this->assertValidHtml($drillDownMenu);
    $this->page->add($drillDownMenu);
    }

  public function testDropDown()
    {
    $dropDown = new \PHPFUI\DropDown(new \PHPFUI\Button('Click Me'), new \PHPFUI\Callout());
    $this->assertValidHtml($dropDown);
    $this->page->add($dropDown);
    }

  public function testDropDownButton()
    {
    $dropDownButton = new \PHPFUI\DropDownButton('Button');
    $this->assertValidHtml($dropDownButton);
    $this->page->add($dropDownButton);
    }

  public function testDropDownMenu()
    {
    $dropDownMenu = new \PHPFUI\DropDownMenu();
    $this->assertValidHtml($dropDownMenu);
    $this->page->add($dropDownMenu);
    }

  public function testEmbed()
    {
    $embed = new \PHPFUI\Embed();
    $this->assertValidHtml($embed);
    $this->page->add($embed);
    }

  public function testEqualizer()
    {
    $equalizer = new \PHPFUI\Equalizer();
    $this->assertValidHtml($equalizer);
    $this->page->add($equalizer);
    }

  public function testFieldSet()
    {
    $fieldSet = new \PHPFUI\FieldSet();
    $this->assertValidHtml($fieldSet);
    $this->page->add($fieldSet);
    }

  public function testForm()
    {
    $form = new \PHPFUI\Form($this->page);
    $this->assertValidHtml($form);
    $this->page->add($form);
    }

  public function testFormError()
    {
    $formError = new \PHPFUI\FormError();
    $this->assertValidHtml($formError);
    $this->page->add($formError);
    }

  public function testGridContainer()
    {
    $gridContainer = new \PHPFUI\GridContainer();
    $this->assertValidHtml($gridContainer);
    $this->page->add($gridContainer);
    }

  public function testGridX()
    {
    $gridX = new \PHPFUI\GridX();
    $this->assertValidHtml($gridX);
    $this->page->add($gridX);
    }

  public function testGridY()
    {
    $gridY = new \PHPFUI\GridY('100em');
    $this->assertValidHtml($gridY);
    $this->page->add($gridY);
    }

  public function testHeader()
    {
    $header = new \PHPFUI\Header('Header');
    $this->assertValidHtml($header);
    $this->page->add($header);
    }

  public function testHTML5Element()
    {
    $hTML5Element = new \PHPFUI\HTML5Element('div');
    $hTML5Element->add('Some text');
    $this->assertValidHtml($hTML5Element);
    $this->page->add($hTML5Element);
    }

  public function testIcon()
    {
    $icon = new \PHPFUI\Icon('edit');
    $this->assertValidHtml($icon);
    $this->page->add($icon);
    }

  public function testImage()
    {
    $image = new \PHPFUI\Image('/test.png');
    $this->assertValidHtml($image);
    $this->page->add($image);
    }

  public function testInput()
    {
    $input = new \PHPFUI\Input('text', 'fred', 'Fred', 'Freddy');
    $this->assertValidHtml($input);
    $this->page->add($input);
    }

  public function testInputGroup()
    {
    $inputGroup = new \PHPFUI\InputGroup();
    $inputGroup->addInput(new \PHPFUI\Input('text', 'fred', 'Fred', 'Freddy'));
    $inputGroup->addLabel('Label');
    $inputGroup->addButton(new \PHPFUI\Button('Button'));
    $this->assertValidHtml($inputGroup);
    $this->page->add($inputGroup);
    }

  public function testLabel()
    {
    $label = new \PHPFUI\Label('Label');
    $this->assertValidHtml($label);
    $this->page->add($label);
    }

  public function testLink()
    {
    $link = new \PHPFUI\Link('http://www.ibm.com', 'IBM');
    $this->assertValidHtml($link);
    $this->page->add($link);
    }

  public function testMediaObject()
    {
    $mediaObject = new \PHPFUI\MediaObject();
    $this->assertValidHtml($mediaObject);
    $this->page->add($mediaObject);
    }

  public function testMenu()
    {
    $menu = new \PHPFUI\Menu('Menu', '/Menu');
    $this->assertValidHtml($menu);
    $this->page->add($menu);
    }

  public function testMultiColumn()
    {
    $multiColumn = new \PHPFUI\MultiColumn(new \PHPFUI\Link('http://www.ibm.com', 'IBM'), new \PHPFUI\Button('Go'));
    $this->assertValidHtml($multiColumn);
    $this->page->add($multiColumn);
    }

  public function testOffCanvas()
    {
    $offCanvas = new \PHPFUI\OffCanvas(new \PHPFUI\Callout());
    $this->assertValidHtml($offCanvas);
    $this->page->add($offCanvas);
    }

  public function testOrbit()
    {
    $orbit = new \PHPFUI\Orbit();
    $orbit->addHTMLSlide(new \PHPFUI\Callout('warning'), 'Warning Will Robinson', true);
    $orbit->addImageSlide(new \PHPFUI\Image('/lostInSpace.png'), 'Will Robinson', true);
    $this->assertValidHtml($orbit);
    $this->page->add($orbit);
    }

  public function testOrderableTable()
    {
    $orderableTable = new \PHPFUI\OrderableTable($this->page);
    $this->assertValidHtml($orderableTable);
    $this->page->add($orderableTable);
    }

  public function testOrderedList()
    {
    $orderedList = new \PHPFUI\OrderedList();
    $orderedList->addItem(new \PHPFUI\ListItem('Item', '/item'));
    $this->assertValidHtml($orderedList);
    $this->page->add($orderedList);
    }

  public function testPagination()
    {
    $pagination = new \PHPFUI\Pagination(10, 100, '/paginate?page=PAGE');
    $this->assertValidHtml($pagination);
    $this->page->add($pagination);
    }

  public function testPanel()
    {
    $panel = new \PHPFUI\Panel('Panel');
    $this->assertValidHtml($panel);
    $this->page->add($panel);
    }

  public function testPayPalExpress()
    {
    $payPalExpress = new \PHPFUI\PayPalExpress($this->page, 'ClientId');
    $this->assertValidHtml($payPalExpress);
    $this->page->add($payPalExpress);
    }

  public function testProgressBar()
    {
    $progressBar = new \PHPFUI\ProgressBar();
    $progressBar->setPercent(50);
    $this->assertValidHtml($progressBar);
    $this->page->add($progressBar);
    }

  public function testRangeSlider()
    {
    $rangeSlider = new \PHPFUI\RangeSlider($this->page, 'name', new \PHPFUI\Input('text', 'value'));
    $this->assertValidHtml($rangeSlider);
    $this->page->add($rangeSlider);
    }

  public function testReCAPTCHA()
    {
    $reCAPTCHA = new \PHPFUI\ReCAPTCHA($this->page, 'public', 'private');
    $this->assertValidHtml($reCAPTCHA);
    $this->page->add($reCAPTCHA);
    }

  public function testReset()
    {
    $reset = new \PHPFUI\Reset();
    $this->assertValidHtml($reset);
    $this->page->add($reset);
    }

  public function testReveal()
    {
    $reveal = new \PHPFUI\Reveal($this->page, new \PHPFUI\Button('Reveal Me'));
    $this->assertValidHtml($reveal);
    $this->page->add($reveal);
    }

  public function testSlickSlider()
    {
    $slickSlider = new \PHPFUI\SlickSlider($this->page);
    $slickSlider->addImage('/test.png')->addSlide(new \PHPFUI\Header('Slide'));
    $this->assertValidHtml($slickSlider);
    $this->page->add($slickSlider);
    }

  public function testSlider()
    {
    $slider = new \PHPFUI\Slider($this->page, 12);
    $this->assertValidHtml($slider);
    $this->page->add($slider);
    }

  public function testSortableTable()
    {
    $sortableTable = new \PHPFUI\SortableTable();
    $this->assertValidHtml($sortableTable);
    $this->page->add($sortableTable);
    }

  public function testSplitButton()
    {
    $splitButton = new \PHPFUI\SplitButton('Text', '/link');
    $this->assertValidHtml($splitButton);
    $this->page->add($splitButton);
    }

  public function testSticky()
    {
    $sticky = new \PHPFUI\Sticky(new \PHPFUI\Callout());
    $this->assertValidHtml($sticky);
    $this->page->add($sticky);
    }

  public function testSubHeader()
    {
    $subHeader = new \PHPFUI\SubHeader('Sub Header');
    $this->assertValidHtml($subHeader);
    $this->page->add($subHeader);
    }

  public function testSubmit()
    {
    $submit = new \PHPFUI\Submit();
    $this->assertValidHtml($submit);
    $this->page->add($submit);
    }

  public function testTable()
    {
    $table = new \PHPFUI\Table();
    $this->assertValidHtml($table);
    $this->page->add($table);
    }

  public function testTabs()
    {
    $tabs = new \PHPFUI\Tabs();
    $this->assertValidHtml($tabs);
    $this->page->add($tabs);
    }

  public function testThumbnail()
    {
    $thumbnail = new \PHPFUI\Thumbnail(new \PHPFUI\Image('/test.png'));
    $this->assertValidHtml($thumbnail);
    $this->page->add($thumbnail);
    }

  public function testTitleBar()
    {
    $titleBar = new \PHPFUI\TitleBar();
    $this->assertValidHtml($titleBar);
    $this->page->add($titleBar);
    }

  public function testToFromList()
    {
    $toFromList = new \PHPFUI\ToFromList($this->page, 'tofrom', [], [], 'index', function(){});
    $this->assertValidHtml($toFromList);
    $this->page->add($toFromList);
    }

  public function testToolTip()
    {
    $toolTip = new \PHPFUI\ToolTip(new \PHPFUI\Button('Tip Me'), 'This is your tip');
    $this->assertValidHtml($toolTip);
    $this->page->add($toolTip);
    }

  public function testTopBar()
    {
    $topBar = new \PHPFUI\TopBar();
    $this->assertValidHtml($topBar);
    $this->page->add($topBar);
    }

  public function testUnorderedList()
    {
    $unorderedList = new \PHPFUI\UnorderedList();
    $unorderedList->addItem(new \PHPFUI\ListItem('Item', '/item'));
    $this->assertValidHtml($unorderedList);
    $this->page->add($unorderedList);
    }

  public function testYouTube()
    {
    $youTube = new \PHPFUI\YouTube(123456789);
    $this->assertValidHtml($youTube);
    $this->page->add($youTube);
    }

  public function testPage()
    {
    $this->assertValidHtml($this->page);
    }

  }