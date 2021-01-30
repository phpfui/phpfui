<?php

namespace PHPFUI;

/**
 * A simple class to contain more complex examples demostrating
 * PHPFUI library methods and techniques.  Also used in unit
 * testing for more complete html tests.
 *
 * @todo
 * AccordionToFromList
 * Link
 * MediaObject
 * PopupInput
 * RadioTable
 * RadioTableCell
 * SortableTable
 * Sticky
 * Tabs
 */
class KitchenSink
	{
	use \PHPFUI\Traits\Page;

	private $index = 0;

	private $lines = [];

	private $page;

	public function __construct(\PHPFUI\Interfaces\Page $page)
		{
		$this->page = $page;
		$index = 0;
		$names = ['Pork', 'Beef', 'Lamb', 'Fish', 'Nuts', 'Fruit', 'Vegtables', 'Bread', 'Pasta', 'Desserts', 'Sugar', ];

		foreach ($names as $name)
			{
			$this->lines[] = ['name' => $name, 'id' => $index++];
			}
		}

	public function baseAccordion() : Accordion
		{
		$accordion = new Accordion();
		$accordion->addTab('Accordion 1', 'some text');
		$accordion->addTab('Accordion 2', 'more some text');
		$accordion->addTab('Accordion 3', 'even more text text');

		return $accordion;
		}

	public function baseAccordionMenu() : AccordionMenu
		{
		$accordionMenu = $this->makeMenu(new AccordionMenu(), 'Accordion Menu', '', $this->subMenu());

		return $accordionMenu;
		}

	public function baseBadge() : Container
		{
		$container = new Container();

		$primaryBadge = new Badge('1');
		$primaryBadge->addClass('primary');
		$container->add($primaryBadge);

		$secondaryBadge = new Badge('2');
		$secondaryBadge->addClass('secondary');
		$container->add($secondaryBadge);

		$successBadge = new Badge('3');
		$successBadge->addClass('success');
		$container->add($successBadge);

		$alertBadge = new Badge('A');
		$alertBadge->addClass('alert');
		$container->add($alertBadge);

		$warningBadge = new Badge('B');
		$warningBadge->addClass('warning');
		$container->add($warningBadge);

		return $container;
		}

	public function baseBreadCrumbs() : BreadCrumbs
		{
		$breadCrumbs = new BreadCrumbs();
		$breadCrumbs->addCrumb('Home', '#');
		$breadCrumbs->addCrumb('Features', '#');
		$breadCrumbs->addCrumb('Gene Splicing');
		$breadCrumbs->addCrumb('Cloning');

		return $breadCrumbs;
		}

	public function baseButton() : Container
		{
		$container = new Container();

		$container->add(new Button('Learn More', '#0'));
		$container->add(new Button('View All Features', '#features'));

		$save = new Button('Save');
		$save->addClass('success');
		$container->add($save);

		$save = new Button('Delete');
		$save->addClass('alert');
		$container->add($save);

		$tiny = new Button('So Tiny', '#0');
		$tiny->addClass('tiny');
		$container->add($tiny);

		$small = new Button('So Small', '#0');
		$small->addClass('small');
		$container->add($small);

		$large = new Button('So Large', '#0');
		$large->addClass('large');
		$container->add($large);

		$expand = new Button('Such Expand', '#0');
		$expand->addClass('expanded');
		$container->add($expand);

		return $container;
		}

	public function baseButtonGroup() : ButtonGroup
		{
		$group = new ButtonGroup();
		$group->addButton(new Button('One'));
		$group->addButton(new Button('Two'));
		$group->addButton(new Button('Three'));

		return $group;
		}

	public function baseCallout() : Container
		{
		$container = new Container();

		foreach (['', 'primary', 'secondary', 'success', 'warning', 'alert'] as $type)
			{
			$callout = new Callout($type);
			$callout->add("<h5>This is a {$type} callout.</h5><p>It has an easy to override visual style, and is appropriately subdued.</p><a href='#'>It's dangerous to go alone, take this.</a>");
			$container->add($callout);
			}

		return $container;
		}

	public function baseCard() : Card
		{
		$card = new Card();
		$card->addDivider(new Header("I'm featured", 4));
		$card->addImage(new Image('https://foundation.zurb.com/sites/docs/assets/img/rectangle-1.jpg'));
		$card->addSection('This card makes use of the card-divider element.');

		return $card;
		}

	public function baseCloseButton() : Container
		{
		$container = new Container();

		$closeBox = new Callout();
		$close = new CloseButton($closeBox);
		$closeBox->add('<p>You can so totally close this!</p>');
		$closeBox->add($close);
		$container->add($closeBox);

		$closeBox = new Callout();
		$closeBox->addClass('success');
		$close = new CloseButton($closeBox, 'slide-out-right');
		$closeBox->add('<p>You can close me too, and I close using a Motion UI animation.</p>');
		$closeBox->add($close);
		$container->add($closeBox);

		return $container;
		}

	public function baseDrillDownMenu() : Container
		{
		$container = new Container();

		$container->add($this->makeMenu(new DrillDownMenu(), 'Drill Down Menu', '', $this->subMenu()));

		$drillDown = $this->makeMenu(new DrillDownMenu(), 'Drill Down Menu Auto Height', '', $this->subMenu());
		$drillDown->setAutoHeight();
		$container->add($drillDown);

		return $container;
		}

	public function baseDropDownButton() : DropDown
		{
		$dropDownButton = new DropDownButton('Drop Down Button');
		$dropMenu = new Menu();
		$dropMenu->addClass('vertical');
		$dropMenu->addAttribute('data-hover', 'true');
		$dropMenu->addAttribute('data-hover-pane', 'true');
		$dropMenu->addMenuItem(new MenuItem('Option 4', '#'));
		$dropMenu->addMenuItem(new MenuItem('Option 3', '#'));
		$dropMenu->addMenuItem(new MenuItem('Option 5', '#'));
		$dropMenu->addMenuItem(new MenuItem('Option 1', '#'));
		$dropMenu->addMenuItem(new MenuItem('Option 2', '#'));
		$dropMenu->sort();

		$dropDown = new DropDown($dropDownButton, $dropMenu);

		return $dropDown;
		}

	public function baseDropDownMenu() : Container
		{
		$container = new Container();

		$container->add($this->makeMenu(new DropDownMenu(), 'Drop Down Menu', '', $this->subMenu()));
		$dropDown = $this->makeMenu(new DropDownMenu(), 'Drop Down Menu Vertical', 'vertical', $this->subMenu());
		$dropDown->computeWidth();
		$container->add($dropDown);

		return $container;
		}

	public function baseDropDownPane() : Container
		{
		$container = new Container();

		$toggleDropdownButton = new Button('Toggle Dropdown');
		$panel = new HTML5Element('div');
		$panel->add('Just some junk that needs to be said. Or not. Your choice.');

		$toggleDropdown = new Dropdown($toggleDropdownButton, $panel);
		$container->add($toggleDropdown);

		$hoverDropdownButton = new Button('Hoverable Dropdown');
		$panel = new HTML5Element('div');
		$panel->add('Just some junk that needs to be said. Or not. Your choice.');

		$hoverDropdown = new Dropdown($hoverDropdownButton, $panel);
		$hoverDropdown->setHover();
		$container->add($hoverDropdown);

		return $container;
		}

	public function baseEqualizer() : Equalizer
		{
		$innerEqualizer = new Equalizer(new Callout());
		$co1 = new Callout('primary');
		$co1->add('This is a callout');
		$co2 = new Callout('warning');
		$co2->add('Warning Will Robinson');
		$co3 = new Callout('error');
		$co3->add('Stack Overflow with much more text and it just keeps going and going.  I wish there was some way to autogenerate text in PHP.');
		$innerEqualizer->addElement($co1);
		$innerEqualizer->addElement($co2);
		$innerEqualizer->addElement($co3);

		$equalizer = new Equalizer();
		$co2 = new Callout();
		$co2->add('This is a callout with much more text and it just keeps going and going.  I wish there was some way to autogenerate text in PHP.');
		$co3 = new Callout();
		$co3->add('This is a callout with medium size text, but not huge.');
		$equalizer->addColumn($innerEqualizer);
		$equalizer->addColumn($co2);
		$equalizer->addColumn($co3);

		return $equalizer;
		}

	public function baseHeader() : Container
		{
		$container = new \PHPFUI\Container();
		$container->add(new \PHPFUI\Header('Header 1', 1));
		$container->add(new \PHPFUI\Header('Header 2'));
		$container->add(new \PHPFUI\Header('Header 3', 3));
		$container->add(new \PHPFUI\Header('Header 4', 4));
		$container->add(new \PHPFUI\Header('Header 5', 5));
		$container->add(new \PHPFUI\Header('Header 6', 6));

		return $container;
		}

	public function baseLabel() : Container
		{
		$container = new Container();

		$label = new Label('Primary Label');
		$label->addClass('primary');
		$container->add($label);

		$label = new Label('Secondary Label');
		$label->addClass('secondary');
		$container->add($label);

		$label = new Label('Success Label');
		$label->addClass('success');
		$container->add($label);

		$label = new Label('Alert Label');
		$label->addClass('alert');
		$container->add($label);

		$label = new Label('Warning Label');
		$label->addClass('warning');
		$container->add($label);

		return $container;
		}

	public function baseMenu() : Container
		{
		$container = new Container();

		$container->add($this->makeMenu(new Menu(), 'Menu'));
		$container->add($this->makeMenu(new Menu(), 'Menu Right', 'align-right'));
		$container->add($this->makeMenu(new Menu(), 'Menu Center', 'align-center'));
		$container->add($this->makeMenu(new Menu(), 'Menu Expanded', 'expanded'));
		$container->add($this->makeMenu(new Menu(), 'Menu Vertical', 'vertical'));
		$container->add($this->makeMenu(new Menu(), 'Menu Vertical Right', 'vertical align-right'));
		$container->add($this->makeMenu(new Menu(), 'Menu Vertical Center', 'vertical align-center'));
		$container->add($this->makeMenu(new Menu(), 'Menu Simple', 'simple'));

		return $container;
		}

	public function baseOffCanvas() : Container
		{
		$container = new Container();

		$main = new HTML5Element('div');
		$main->add('This is the main content for the off canvas');

		$offCanvas = new OffCanvas($main);

		$off = new HTML5Element('div');
		$off->add('
				<button class="close-button" aria-label="Close menu" type="button" data-close>
					<span aria-hidden="true">&times;</span>
				</button>
				<ul class="vertical menu">
					<li><a href="#">Foundation</a></li>
					<li><a href="#">Dot</a></li>
					<li><a href="#">ZURB</a></li>
					<li><a href="#">Com</a></li>
					<li><a href="#">Slash</a></li>
					<li><a href="#">Sites</a></li>
				</ul>');

		$toggle = new Button('Toggle OffCanvas');
		$offCanvas->addOff($off, $toggle);

		$container->add($offCanvas);
		$container->add($toggle);

		return $container;
		}

	public function baseOrbit() : Orbit
		{
		$orbit = new Orbit('Some out of the world images');
		$orbit->addImageSlide(new Image('https://foundation.zurb.com/sites/docs/assets/img/orbit/01.jpg'), 'Space, the final frontier.');
		$orbit->addImageSlide(new Image('https://foundation.zurb.com/sites/docs/assets/img/orbit/02.jpg'), 'Lets Rocket!', true);
		$orbit->addImageSlide(new Image('https://foundation.zurb.com/sites/docs/assets/img/orbit/03.jpg'), 'Encapsulating');
		$orbit->addImageSlide(new Image('https://foundation.zurb.com/sites/docs/assets/img/orbit/04.jpg'), 'Outta This World');

		return $orbit;
		}

	public function baseOrderedList() : OrderedList
		{
		$orderedList = new \PHPFUI\OrderedList();
		$orderedList->addItem(new \PHPFUI\ListItem('Item 1', '/item#1'));
		$orderedList->addItem(new \PHPFUI\ListItem('Item 2', '/item#2'));
		$orderedList->addItem(new \PHPFUI\ListItem('Item 3', '/item#3'));

		return $orderedList;
		}

	public function baseProgressBar() : Container
		{
		$container = new Container();

		$bar = new ProgressBar();
		$bar->addClass('primary');
		$bar->setCurrent(25);
		$container->add($bar);

		$bar = new ProgressBar();
		$bar->addClass('warning');
		$bar->setCurrent(50);
		$container->add($bar);

		$bar = new ProgressBar();
		$bar->addClass('alert');
		$bar->setCurrent(75);
		$container->add($bar);

		$bar = new ProgressBar();
		$bar->addClass('success');
		$bar->setCurrent(100);
		$container->add($bar);

		return $container;
		}

	public function baseResponsiveEmbed() : Embed
		{
		$embed = new Embed();
		$embed->add(new YouTube('WUgvvPRH7Oc'));

		return $embed;
		}

	public function baseReveal() : Container
		{
		$container = new Container();

		$openButton = new Button('Click me for a modal');
		$container->add($openButton);

		$reveal = new Reveal($this->page, $openButton);
		$reveal->add(new Header('Awesome. I Have It.'));
		$reveal->add('<p class="lead">Your couch. It is mine.</p>');
		$reveal->add("<p>I'm a cool paragraph that lives inside of an even cooler modal. Wins!</p>");

		$nestedButton = new Button('Click me for a nested modal');
		$container->add($nestedButton);

		$nestedReveal = new Reveal($this->page, $nestedButton);
		$nestedReveal->add(new Header('Awesome!'));
		$nestedReveal->add('<p class="lead">I have another modal inside of me!</p>');

		$nestedRevealButton = new Button('Click me for another modal!');
		$nestedReveal->add($nestedRevealButton);

		$nestedReveal2 = new Reveal($this->page, $nestedRevealButton);
		$nestedReveal2->add(new Header('ANOTHER MODAL!!!'));

		return $container;
		}

	public function baseSlider() : Container
		{
		$container = new Container();

		$container->add(new Slider(25));

		$data = new Input('number', 'data');
		$slider = new Slider(12, new SliderHandle(12, $data));
		$slider->setVertical();
		$container->add($slider);
		$container->add($data);

		$firstHandle = new Input('number', 'first');
		$secondHandle = new Input('number', 'second');
		$slider = new Slider(25, new SliderHandle(25, $firstHandle));
		$slider->setRangeHandle(new SliderHandle(75, $secondHandle));
		$container->add($slider);
		$container->add($firstHandle);
		$container->add($secondHandle);

		return $container;
		}

	public function baseSplitButton() : SplitButton
		{
		$splitButton = new SplitButton('Split', '#');
		$splitButton->addMenuItem(new MenuItem('Option 4', '#'));
		$splitButton->addMenuItem(new MenuItem('Option 3', '#'));
		$splitButton->addMenuItem(new MenuItem('Option 5', '#'));
		$splitButton->addMenuItem(new MenuItem('Option 1', '#'));
		$splitButton->addMenuItem(new MenuItem('Option 2', '#'));
		$splitButton->sort();

		return $splitButton;
		}

	public function baseSubmit() : Container
		{
		$container = new \PHPFUI\Container();

		$container->add(new \PHPFUI\Submit());
		$container->add(new \PHPFUI\Submit('Submit', 'action'));

		return $container;
		}

	public function baseSwitchCheckBox() : Container
		{
		$container = new Container();

		$switchCB = new Input\SwitchCheckBox('name', true, 'Do you like me?');
		$switchCB->setActiveLabel('Yes')->setInactiveLabel('No')->addClass('large');
		$container->add($switchCB);

		return $container;
		}

	public function baseSwitchRadio() : Container
		{
		$container = new Container();

		$switchRB1 = new Input\SwitchRadio('radio', 1);
		$switchRB1->setActiveLabel('Yes')->setInactiveLabel('No')->addClass('large');
		$container->add($switchRB1);

		$switchRB2 = new Input\SwitchRadio('radio', 2);
		$container->add($switchRB2->setChecked());

		$switchRB3 = new Input\SwitchRadio('radio', 3);
		$container->add($switchRB3->addClass('tiny'));

		return $container;
		}

	public function baseTable() : Table
		{
		$table = new \PHPFUI\Table();
		$table->setCaption('This is the table caption');
		$table->addArrowNavigation($this->page);
		$headers = ['Some', 'Numbers', '4', 'U', 'Edit', 'CheckBox'];
		$table->setHeaders($headers);
		$table->addColumnAttribute('Numbers', ['class' => 'warning']);
		$table->setFooters(array_combine($headers, $headers));

		for ($i = 0; $i < 10; ++$i)
			{
			$numbers = [];

			foreach ($headers as $field)
				{
				$numbers[$field] = rand();
				}

			$numbers['Edit'] = new Input\Text('edit[]');
			$numbers['CheckBox'] = new Input\CheckBox('check[]');
			$table->addRow($numbers);
			}

		return $table;
		}

  public function baseTabs() : Container
    {
    $container = new Container();

    $tabs = new Tabs();
    $tabs->addTab('One', 'Check me out! I\'m a super cool Tab panel with text content!');
    $image = new Image('/images/rectangle-1.jpg');
    $tabs->addTab('Two', $image);
    $tabs->addTab('Three', '', true);
    $tabs->addTab('Four', $image);
    $container->add($tabs);

    $grid = new GridX();
    $grid->setMargin();
    $cell = new Cell(3, 2, 1);
    $vtabs = new Tabs(true);
    $vtabs->addTab('One', 'Check me out! I\'m VERTICAL!');
    $vtabs->addTab('Two', $image);
    $vtabs->addTab('Three', '', true);
    $vtabs->addTab('Four', $image);
    $cell->add($vtabs->getTabs());
    $grid->add($cell);
    $content = new Cell();
    $content->add($vtabs->getContent());
    $grid->add($content);
    $gridContainer = new GridContainer();
    $gridContainer->add($grid);
    $container->add($gridContainer);

    return $container;
    }

	public function baseThumbnail() : Container
		{
		$container = new Container();

		$container->add(new Thumbnail(new Image('https://foundation.zurb.com/sites/docs/assets/img/thumbnail/01.jpg')));
		$container->add(new Thumbnail(new Image('https://foundation.zurb.com/sites/docs/assets/img/thumbnail/02.jpg')));
		$container->add(new Thumbnail(new Image('https://foundation.zurb.com/sites/docs/assets/img/thumbnail/03.jpg')));

		return $container;
		}

	public function baseTitleBar() : TitleBar
		{
		$titlebar = new TitleBar('TitleBar');
		$titlebar->addLeft('<button class="menu-icon" type="button"></button>');
		$titlebar->addRight('<button class="menu-icon" type="button"></button>');

		return $titlebar;
		}

	public function baseToggler() : Container
		{
		$container = new Container();

		$toggleAll = new Button('Toggle All These');

		$image1 = new Thumbnail(new Image('https://foundation.zurb.com/sites/docs/assets/img/thumbnail/01.jpg'));
		$image2 = new Thumbnail(new Image('https://foundation.zurb.com/sites/docs/assets/img/thumbnail/02.jpg'));
		$image3 = new Thumbnail(new Image('https://foundation.zurb.com/sites/docs/assets/img/thumbnail/03.jpg'));

		$toggleAll->toggleAnimate($image1, 'hinge-in-from-left spin-out');
		$toggleAll->toggleAnimate($image2, 'hinge-in-from-bottom fade-out');
		$toggleAll->toggleAnimate($image3, 'slide-in-down slide-out-up');

		$container->add(new MultiColumn($toggleAll));
		$container->add($image1);
		$container->add($image2);
		$container->add($image3);

		$toggleFocus = new Input\Text('test', 'Toggle on Focus');

		$callout = new Callout('secondary');
		$callout->add('<p>This is only visible when the above field has focus.</p>');

		$toggleFocus->toggleFocus($callout, 'hinge-in-from-top hinge-out-from-bottom');

		$container->add(new MultiColumn($toggleFocus));
		$container->add($callout);

		return $container;
		}

	public function baseToolTip() : Container
		{
		$container = new Container();

		$toolTip = new ToolTip('scarabaeus', 'Fancy word for a beetle');
		$container->add("<p>The {$toolTip} hung quite clear of any branches, and, if allowed to fall, would have fallen at our feet. Legrand immediately took the scythe, and cleared with it a circular space, three or four yards in diameter, just beneath the insect, and, having accomplished this, ordered Jupiter to let go the string and come down from the tree.</p>");

		return $container;
		}

	public function baseTopBar() : TopBar
		{
		$topbar = new TopBar();
		$topbar->addLeft($this->makeMenu(new DropDownMenu(), 'Site Title', '', $this->subMenu()));

		$menu = new Menu();
		$search = new Input('search', '');
		$search->addAttribute('placeholder', 'Search');
		$menu->addMenuItem(new MenuItem($search));
		$menu->addMenuItem(new MenuItem(new Button('Search')));
		$topbar->addRight($menu);

		return $topbar;
		}

	public function baseUnorderedList() : UnorderedList
		{
		$unorderedList = new \PHPFUI\UnorderedList();
		$unorderedList->addItem(new \PHPFUI\ListItem('Item', '/item'));
		$unorderedList->addItem(new \PHPFUI\ListItem('Item 1', '/item#1'));
		$unorderedList->addItem(new \PHPFUI\ListItem('Item C', '/item#c'));

		return $unorderedList;
		}

	public function extraDebug() : Container
		{
		$container = new \PHPFUI\Container();

		$container->add(new Debug($this, 'Debug $this!'));

		return $container;
		}

	public function extraIcon() : Container
		{
		$container = new \PHPFUI\Container();

		$iconPlain = new Icon('edit');
		$container->add($iconPlain);
		$iconPlainTip = new Icon('edit');
		$iconPlainTip->setTooltip('I am a plain icon with a tooltip');
		$container->add($iconPlainTip);
		$iconLink = new Icon('edit', '#');
		$container->add($iconLink);
		$iconLinkTip = new Icon('edit', '#');
		$iconLinkTip->setTooltip('I can even have a tooltip and a link!');
		$container->add($iconLinkTip);

		return $container;
		}

	public function extraOrderableTable() : OrderableTable
		{
		$table = new \PHPFUI\OrderableTable($this->page);
		$table->setCaption('This is the table caption');
		$table->addArrowNavigation($this->page);
		$headers = ['Some', 'Numbers', '4', 'U', 'Edit', 'CheckBox'];
		$table->setHeaders($headers);
		$table->addColumnAttribute('Numbers', ['class' => 'warning']);
		$table->setFooters(array_combine($headers, $headers));

		for ($i = 0; $i < 10; ++$i)
			{
			$numbers = [];

			foreach ($headers as $field)
				{
				$numbers[$field] = rand();
				}

			$numbers['Edit'] = new Input\Text('edit[]');
			$numbers['CheckBox'] = new Input\CheckBox('check[]');
			$table->addRow($numbers);
			}

		return $table;
		}

	public function extraPagination() : Pagination
		{
		$pagination = new Pagination(50, 100, '#');

		return $pagination;
		}

	public function extraPanel() : Panel
		{
		$panel = new Panel('This is a panel with a radius');
		$panel->setRadius();

		return $panel;
		}

	public function extraSlickSlider() : SlickSlider
		{
		$slickSlider = new \PHPFUI\SlickSlider($this->page);
		$slickSlider->addImage('https://foundation.zurb.com/sites/docs/assets/img/orbit/01.jpg', 'Space, the final frontier.');
		$slickSlider->addImage('https://foundation.zurb.com/sites/docs/assets/img/orbit/02.jpg', 'Lets Rocket!', true);
		$slickSlider->addImage('https://foundation.zurb.com/sites/docs/assets/img/orbit/03.jpg', 'Encapsulating');
		$slickSlider->addImage('https://foundation.zurb.com/sites/docs/assets/img/orbit/04.jpg', 'Outta This World');

		return $slickSlider;
		}

	public function extraSubHeader()
		{
		$subHeader = new \PHPFUI\SubHeader('Sub Header');

		return $subHeader;
		}

	public function extraTimedCellUpdate() : HTML5Element
		{
		$div = new HTML5Element('div');

		$timedCellUpdate = new TimedCellUpdate($this->page, $div->getId(), [$this, 'timedCellUpdateCallback'], 1);

		return $div;
		}

	public function extraToFromList() : ToFromList
		{
		$index = 'id';
		$callback = [$this, 'getToFromListName'];
		$split = mt_rand(0, count($this->lines) - 1);
		$notInGroup = array_slice($this->lines, $split);
		$inGroup = array_slice($this->lines, 0, $split);
		$toFromList = new \PHPFUI\ToFromList($this->page, 'groups', $inGroup, $notInGroup, $index, $callback);
		$toFromList->setInName('In Group');
		$toFromList->setOutName('Out Group');

		return $toFromList;
		}

	/**
		 * Get all the example functions
		 *
		 * return array of method names indexed by English name
		 */
	public function getExamples(string $prefix = 'base') : array
		{
		$examples = [];

		$prefixLen = strlen($prefix);
		$methods = get_class_methods(self::class);

		foreach ($methods as $methodName)
			{
			if (0 === strpos($methodName, $prefix))
				{
				$name = substr($methodName, $prefixLen);
				$examples[$name] = $methodName;
				}
			}

		return $examples;
		}

	public function getToFromListName(string $fieldName, string $indexName, string $index, string $type) : string
		{
		$line = $this->lines[$index];
		$hidden = new \PHPFUI\Input\Hidden($type . $fieldName . '[]', $line[$indexName]);

		return "{$hidden}" . $line['name'];
		}

	public function render(string $type = 'base') : string
		{
		$container = new Container();

		$examples = $this->getExamples($type);

		ksort($examples);

		$hr = '';
		$realHr = new HTML5Element('hr');

		foreach ($examples as $name => $example)
			{
			$container->add($hr);
			$container->add(new Header($name, 3));
			$container->add($this->{$example}());

			if ($this->page->isDone())
				{
				return '';
				}

			$hr = $realHr;
			}

		return "{$container}";
		}

	public function timedCellUpdateCallback(string $id) : string
		{
		return gmdate('H:i:s') . ' ' . $id;
		}

	private function generateMenu(string $name, int $count, bool $active = false) : Menu
		{
		$names = ['One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten'];
		$menu = new Menu();
		$count = min($count, 10);

		for ($i = 0; $i < $count; ++$i)
			{
			$item = new MenuItem($names[$i] . ' ' . $name, '#');
			$item->setActive($active);
			$active = false;
			$menu->addMenuItem($item);
			}

		return $menu;
		}

	private function makeMenu(Menu $menu, string $name, ?string $class = '', ?Menu $subMenu = null) : Menu
		{
		$menu->addMenuItem(new MenuItem($name));
		$menu->addMenuItem(new MenuItem('One', '#'));
		$menu->addMenuItem(new MenuItem('Two', '#'));
		$three = new MenuItem('Three', '#');

		if ($subMenu)
			{
			$menu->addSubMenu($three, $subMenu);
			}
		else
			{
			$three->setActive(true);
			$menu->addMenuItem($three);
			}

		$menu->addMenuItem(new MenuItem('Four', '#'));

		if ($class)
			{
			$menu->addClass($class);
			}

		return $menu;
		}

	private function section(string $name) : Container
		{
		$container = new Container();

		$container->add(new HTML5Element('hr'));
		$container->add(new Header($header, 2));

		return $container;
		}

	private function subMenu() : Menu
		{
		$menu = new Menu();
		$menu->addMenuItem(new MenuItem('One A', '#'));
		$menu->addMenuItem(new MenuItem('Two A', '#'));
		$menu->addMenuItem(new MenuItem('Three A', '#'));
		$menu->addSubMenu(new MenuItem('Four A', '#'), $this->generateMenu('B', 3, true));
		$menu->addSubMenu(new MenuItem('Five A', '#'), $this->generateMenu('C', 10));

		return $menu;
		}
	}
