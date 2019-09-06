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

require_once("bootstrap.php");

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
		}

	public function testAccordionMenu()
		{
		$accordianMenu = new \PHPFUI\AccordionMenu();
		AssertHTML5::isValidMarkup($accordianMenu);
		}

	public function testAccordionTabs()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\AccordionTabs($this->page));
		}

	public function testAccordionToFromList()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\AccordionToFromList($this->page, 'fieldName', [], [], 'callbackIndex', function(){}));
		}

	public function testBadge()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\Badge('badge'));
		}

	public function testBlockGrid()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\BlockGrid());
		}

	public function testBreadCrumbs()
		{
		$crumbs = new \PHPFUI\BreadCrumbs();
		$crumbs->addCrumb('Crumb', '/Crumby');
		AssertHTML5::isValidMarkup($crumbs);
		}

	public function testButton()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\Button('Click Me'));
		}

	public function testButtonGroup()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\ButtonGroup());
		}

	public function testCallout()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\Callout());
		}

	public function testCancel()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\Cancel());
		}

	public function testCard()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\Card());
		}

	public function testCell()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\Cell());
		}

	public function testCloseButton()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\CloseButton(new \PHPFUI\Button('Close Me')));
		}

	public function testDisplay()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\Display('label', 'text'));
		}

	public function testDrillDownMenu()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\DrillDownMenu());
		}

	public function testDropDown()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\DropDown(new \PHPFUI\Button('Click Me'), new \PHPFUI\Callout()));
		}

	public function testDropDownButton()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\DropDownButton('Button'));
		}

	public function testDropDownMenu()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\DropDownMenu());
		}

	public function testEMailButton()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\EMailButton('Button'));
		}

	public function testEmbed()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\Embed());
		}

	public function testEqualizer()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\Equalizer());
		}

	public function testFieldSet()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\FieldSet());
		}

	public function testFlexVideo()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\FlexVideo());
		}

	public function testForm()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\Form($this->page));
		}

	public function testFormError()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\FormError());
		}

	public function testGridContainer()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\GridContainer());
		}

	public function testGridX()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\GridX());
		}

	public function testGridY()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\GridY('100em'));
		}

	public function testHeader()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\Header('Header'));
		}

	public function testHTML5Element()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\HTML5Element('div'));
		}

	public function testIcon()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\Icon('edit'));
		}

	public function testImage()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\Image('/test.png'));
		}

	public function testInput()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\Input('text', 'fred', 'Fred', 'Freddy'));
		}

	public function testInputGroup()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\InputGroup());
		}

	public function testLabel()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\Label('Label'));
		}

	public function testLink()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\Link('http://www.ibm.com'));
		}

	public function testMediaObject()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\MediaObject());
		}

	public function testMenu()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\Menu('Menu', '/Menu'));
		}

	public function testMultiColumn()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\MultiColumn());
		}

	public function testOffCanvas()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\OffCanvas(new \PHPFUI\Callout()));
		}

	public function testOrbit()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\Orbit());
		}

	public function testOrderableTable()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\OrderableTable($this->page));
		}

	public function testOrderedList()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\OrderedList());
		}

	public function testPagination()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\Pagination(10, 100, '/paginate?page=PAGE'));
		}

	public function testPanel()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\Panel());
		}

	public function testPayPalExpress()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\PayPalExpress($this->page, 'ClientId'));
		}

	public function testProgressBar()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\ProgressBar());
		}

	public function testRangeSlider()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\RangeSlider($this->page, 'name', new \PHPFUI\Input('text', 'value')));
		}

	public function testReCAPTCHA()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\ReCAPTCHA($this->page, 'public', 'private'));
		}

	public function testReset()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\Reset());
		}

	public function testReveal()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\Reveal($this->page, new \PHPFUI\Button('Reveal Me')));
		}

	public function testSlickSlider()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\SlickSlider($this->page));
		}

	public function testSlider()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\Slider($this->page, 12));
		}

	public function testSliderHandle()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\SliderHandle());
		}

	public function testSortableTable()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\SortableTable());
		}

	public function testSplitButton()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\SplitButton('Text', '/link'));
		}

	public function testSticky()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\Sticky(new \PHPFUI\Callout()));
		}

	public function testSubHeader()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\SubHeader('Sub Header'));
		}

	public function testSubmit()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\Submit());
		}

	public function testTable()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\Table());
		}

	public function testTabs()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\Tabs());
		}

	public function testThumbnail()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\Thumbnail(new \PHPFUI\Image('/test.png')));
		}

//	public function testTimedCellUpdate()
//		{
//		AssertHTML5::isValidMarkup(new \PHPFUI\TimedCellUpdate($this->page, 'id1', function(){return '';}));
//		}

	public function testTitleBar()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\TitleBar());
		}

	public function testToFromList()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\ToFromList($this->page, 'tofrom', [], [], 'index', function(){}));
		}

	public function testToolTip()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\ToolTip(new \PHPFUI\Button('Tip Me'), 'This is your tip'));
		}

	public function testTopBar()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\TopBar());
		}

	public function testUnorderedList()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\UnorderedList());
		}

	public function testYouTube()
		{
		AssertHTML5::isValidMarkup(new \PHPFUI\YouTube(123456789));
		}

	public function testPage()
		{
		AssertHTML5::isValidMarkup($this->page);
		}

}