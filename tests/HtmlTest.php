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
	private $ks;

	private $page;

	public function setUp() : void
		{
		$this->page = new \PHPFUI\Page();
		$this->ks = new \PHPFUI\KitchenSink($this->page);
		}

	public function testBlockGrid()
		{
		$blockGrid = new \PHPFUI\BlockGrid();
		$this->assertValidHtml($blockGrid);
		}

	public function testCancel()
		{
		$this->assertValidHtml(new \PHPFUI\Cancel('Cancel Me!'));
		}

	public function testCell()
		{
		$cell = new \PHPFUI\Cell();
		$this->assertValidHtml($cell);
		}

	public function testDisplay()
		{
		$display = new \PHPFUI\Display('label', 'text');
		$this->assertValidHtml($display);
		}

	public function testFieldSet()
		{
		$fieldSet = new \PHPFUI\FieldSet();
		$this->assertValidHtml($fieldSet);
		}

	public function testForm()
		{
		$form = new \PHPFUI\Form($this->page);
		$this->assertValidHtml($form);
		}

	public function testFormError()
		{
		$formError = new \PHPFUI\FormError();
		$this->assertValidHtml($formError);
		}

	public function testGridContainer()
		{
		$gridContainer = new \PHPFUI\GridContainer();
		$this->assertValidHtml($gridContainer);
		}

	public function testGridX()
		{
		$gridX = new \PHPFUI\GridX();
		$this->assertValidHtml($gridX);
		}

	public function testGridY()
		{
		$gridY = new \PHPFUI\GridY('100em');
		$this->assertValidHtml($gridY);
		}

	public function testHeader()
		{
		$header = new \PHPFUI\Header('Header');
		$this->assertValidHtml($header);
		}

	public function testHTML5Element()
		{
		$hTML5Element = new \PHPFUI\HTML5Element('div');
		$hTML5Element->add('Some text');
		$this->assertValidHtml($hTML5Element);
		}

	public function testIcon()
		{
		$icon = new \PHPFUI\Icon('edit');
		$this->assertValidHtml($icon);
		}

	public function testImage()
		{
		$image = new \PHPFUI\Image('/test.png');
		$this->assertValidHtml($image);
		}

	public function testInput()
		{
		$input = new \PHPFUI\Input('text', 'fred', 'Fred', 'Freddy');
		$this->assertValidHtml($input);
		}

	public function testInputGroup()
		{
		$inputGroup = new \PHPFUI\InputGroup();
		$inputGroup->addInput(new \PHPFUI\Input('text', 'fred', 'Fred', 'Freddy'));
		$inputGroup->addLabel('Label');
		$inputGroup->addButton(new \PHPFUI\Button('Button'));
		$this->assertValidHtml($inputGroup);
		}

	public function testKitchenSink()
		{
		$this->assertValidHtml($this->ks->render());
		}

	public function testKitchenSinkExamples() : void
		{
		$examples = $this->ks->getExamples();
		foreach ($examples as $name => $example)
			{
			$this->assertValidHtml($this->ks->$example(), $name);
			}
		}

	public function testLabel()
		{
		$label = new \PHPFUI\Label('Label');
		$this->assertValidHtml($label);
		}

	public function testLink()
		{
		$link = new \PHPFUI\Link('http://www.ibm.com', 'IBM');
		$this->assertValidHtml($link);
		$this->assertValidHtml(\PHPFUI\Link::email('test@example.com', 'Test Example', 'What\'s up?'));
		$this->assertValidHtml(\PHPFUI\Link::phone('867-5309', 'Jenny'));
		}

	public function testMediaObject()
		{
		$mediaObject = new \PHPFUI\MediaObject();
		$this->assertValidHtml($mediaObject);
		}

	public function testMultiColumn()
		{
		$multiColumn = new \PHPFUI\MultiColumn(new \PHPFUI\Link('http://www.ibm.com', 'IBM'), new \PHPFUI\Button('Go'));
		$this->assertValidHtml($multiColumn);
		}

	public function testOrderableTable()
		{
		$orderableTable = new \PHPFUI\OrderableTable($this->page);
		$this->assertValidHtml($orderableTable);
		}

	public function testOrderedList()
		{
		$orderedList = new \PHPFUI\OrderedList();
		$orderedList->addItem(new \PHPFUI\ListItem('Item', '/item'));
		$this->assertValidHtml($orderedList);
		}

	public function testPage()
		{
		$this->assertValidHtml($this->page);
		}

	public function testPanel()
		{
		$panel = new \PHPFUI\Panel('Panel');
		$this->assertValidHtml($panel);
		}

	public function testPayPalExpress()
		{
		$payPalExpress = new \PHPFUI\PayPalExpress($this->page, 'ClientId');
		$this->assertValidHtml($payPalExpress);
		}

	public function testReCAPTCHA()
		{
		$reCAPTCHA = new \PHPFUI\ReCAPTCHA($this->page, 'public', 'private');
		$this->assertValidHtml($reCAPTCHA);
		}

	public function testReset()
		{
		$reset = new \PHPFUI\Reset();
		$this->assertValidHtml($reset);
		}

	public function testSlickSlider()
		{
		$slickSlider = new \PHPFUI\SlickSlider($this->page);
		$slickSlider->addImage('/test.png')->addSlide(new \PHPFUI\Header('Slide'));
		$this->assertValidHtml($slickSlider);
		}

	public function testSortableTable()
		{
		$sortableTable = new \PHPFUI\SortableTable();
		$this->assertValidHtml($sortableTable);
		}

	public function testSticky()
		{
		$sticky = new \PHPFUI\Sticky(new \PHPFUI\Callout());
		$this->assertValidHtml($sticky);
		}

	public function testSubHeader()
		{
		$subHeader = new \PHPFUI\SubHeader('Sub Header');
		$this->assertValidHtml($subHeader);
		}

	public function testSubmit()
		{
		$submit = new \PHPFUI\Submit();
		$this->assertValidHtml($submit);
		}

	public function testTable()
		{
		$table = new \PHPFUI\Table();
		$this->assertValidHtml($table);
		}

	public function testToFromList()
		{
		$toFromList = new \PHPFUI\ToFromList($this->page, 'tofrom', [], [], 'index', function()
			{
			});
		$this->assertValidHtml($toFromList);
		}

	public function testUnorderedList()
		{
		$unorderedList = new \PHPFUI\UnorderedList();
		$unorderedList->addItem(new \PHPFUI\ListItem('Item', '/item'));
		$this->assertValidHtml($unorderedList);
		}

	public function testYouTube()
		{
		$youTube = new \PHPFUI\YouTube('123456789');
		$this->assertValidHtml($youTube);
		}
	}

