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

	/** @var array<array<string, int | string>> */
	private array $lines = [];

	public function __construct(private \PHPFUI\Page $page)
		{
		$index = 0;
		$names = ['Pork', 'Beef', 'Lamb', 'Fish', 'Nuts', 'Fruit', 'Vegtables', 'Bread', 'Pasta', 'Desserts', 'Sugar', ];

		foreach ($names as $name)
			{
			$this->lines[] = ['name' => $name, 'id' => $index++];
			}
		}

	public function baseAccordion() : Accordion
		{
		$accordion = new \PHPFUI\Accordion();
		$accordion->addTab('Accordion 1', 'some text');
		$accordion->addTab('Accordion 2', 'more some text');
		$accordion->addTab('Accordion 3', 'even more text text');

		return $accordion;
		}

	public function baseAccordionMenu() : Menu
		{
		$accordionMenu = $this->makeMenu(new \PHPFUI\AccordionMenu(), 'Accordion Menu', '', $this->subMenu());

		return $accordionMenu;
		}

	public function baseBadge() : Container
		{
		$container = new \PHPFUI\Container();

		$primaryBadge = new \PHPFUI\Badge('1');
		$primaryBadge->addClass('primary');
		$container->add($primaryBadge);

		$secondaryBadge = new \PHPFUI\Badge('2');
		$secondaryBadge->addClass('secondary');
		$container->add($secondaryBadge);

		$successBadge = new \PHPFUI\Badge('3');
		$successBadge->addClass('success');
		$container->add($successBadge);

		$alertBadge = new \PHPFUI\Badge('A');
		$alertBadge->addClass('alert');
		$container->add($alertBadge);

		$warningBadge = new \PHPFUI\Badge('B');
		$warningBadge->addClass('warning');
		$container->add($warningBadge);

		return $container;
		}

	public function baseBreadCrumbs() : BreadCrumbs
		{
		$breadCrumbs = new \PHPFUI\BreadCrumbs();
		$breadCrumbs->addCrumb('Home', '#');
		$breadCrumbs->addCrumb('Features', '#');
		$breadCrumbs->addCrumb('Gene Splicing');
		$breadCrumbs->addCrumb('Cloning');

		return $breadCrumbs;
		}

	public function baseButton() : Container
		{
		$container = new \PHPFUI\Container();

		$container->add(new \PHPFUI\Button('Learn More', '#0'));
		$container->add(new \PHPFUI\Button('View All Features', '#features'));

		$save = new \PHPFUI\Button('Save');
		$save->addClass('success');
		$container->add($save);

		$save = new \PHPFUI\Button('Delete');
		$save->addClass('alert');
		$container->add($save);

		$tiny = new \PHPFUI\Button('So Tiny', '#0');
		$tiny->addClass('tiny');
		$container->add($tiny);

		$small = new \PHPFUI\Button('So Small', '#0');
		$small->addClass('small');
		$container->add($small);

		$large = new \PHPFUI\Button('So Large', '#0');
		$large->addClass('large');
		$container->add($large);

		$expand = new \PHPFUI\Button('Such Expand', '#0');
		$expand->addClass('expanded');
		$container->add($expand);

		return $container;
		}

	public function baseButtonGroup() : ButtonGroup
		{
		$group = new \PHPFUI\ButtonGroup();
		$group->addButton(new \PHPFUI\Button('One'));
		$group->addButton(new \PHPFUI\Button('Two'));
		$group->addButton(new \PHPFUI\Button('Three'));

		return $group;
		}

	public function baseCallout() : Container
		{
		$container = new \PHPFUI\Container();

		foreach (['', 'primary', 'secondary', 'success', 'warning', 'alert'] as $type)
			{
			$callout = new \PHPFUI\Callout($type);
			$callout->add("<h5>This is a {$type} callout.</h5><p>It has an easy to override visual style, and is appropriately subdued.</p><a href='#'>It's dangerous to go alone, take this.</a>");
			$container->add($callout);
			}

		return $container;
		}

	public function baseCard() : Card
		{
		$card = new \PHPFUI\Card();
		$card->addDivider(new \PHPFUI\Header("I'm featured", 4));
		$card->addImage(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/rectangle-1.jpg'));
		$card->addSection('This card makes use of the card-divider element.');

		return $card;
		}

	public function baseCloseButton() : Container
		{
		$container = new \PHPFUI\Container();

		$closeBox = new \PHPFUI\Callout();
		$close = new \PHPFUI\CloseButton($closeBox);
		$closeBox->add('<p>You can so totally close this!</p>');
		$closeBox->add($close);
		$container->add($closeBox);

		$closeBox = new \PHPFUI\Callout();
		$closeBox->addClass('success');
		$close = new \PHPFUI\CloseButton($closeBox, 'slide-out-right');
		$closeBox->add('<p>You can close me too, and I close using a Motion UI animation.</p>');
		$closeBox->add($close);
		$container->add($closeBox);

		return $container;
		}

	public function baseDrillDownMenu() : Container
		{
		$container = new \PHPFUI\Container();

		$container->add($this->makeMenu(new \PHPFUI\DrillDownMenu(), 'Drill Down Menu', '', $this->subMenu()));

		$drillDownMenu = new \PHPFUI\DrillDownMenu();
		$drillDownMenu->setAutoHeight();
		$drillDown = $this->makeMenu($drillDownMenu, 'Drill Down Menu Auto Height', '', $this->subMenu());
		$container->add($drillDown);

		return $container;
		}

	public function baseDropDownButton() : DropDown
		{
		$dropDownButton = new \PHPFUI\DropDownButton('Drop Down Button');
		$dropMenu = new \PHPFUI\Menu();
		$dropMenu->addClass('vertical');
		$dropMenu->addAttribute('data-hover', 'true');
		$dropMenu->addAttribute('data-hover-pane', 'true');
		$dropMenu->addMenuItem(new \PHPFUI\MenuItem('Option 4', '#'));
		$dropMenu->addMenuItem(new \PHPFUI\MenuItem('Option 3', '#'));
		$dropMenu->addMenuItem(new \PHPFUI\MenuItem('Option 5', '#'));
		$dropMenu->addMenuItem(new \PHPFUI\MenuItem('Option 1', '#'));
		$dropMenu->addMenuItem(new \PHPFUI\MenuItem('Option 2', '#'));
		$dropMenu->sort();

		$dropDown = new \PHPFUI\DropDown($dropDownButton, $dropMenu);

		return $dropDown;
		}

	public function baseDropDownMenu() : Container
		{
		$container = new \PHPFUI\Container();

		$container->add($this->makeMenu(new \PHPFUI\DropDownMenu(), 'Drop Down Menu', '', $this->subMenu()));
		$dropDownMenu = new \PHPFUI\DropDownMenu();
		$dropDownMenu->computeWidth();
		$dropDown = $this->makeMenu($dropDownMenu, 'Drop Down Menu Vertical', 'vertical', $this->subMenu());
		$container->add($dropDown);

		return $container;
		}

	public function baseDropDownPane() : Container
		{
		$container = new \PHPFUI\Container();

		$toggleDropdownButton = new \PHPFUI\Button('Toggle Dropdown');
		$panel = new \PHPFUI\HTML5Element('div');
		$panel->add('Just some junk that needs to be said. Or not. Your choice.');

		$toggleDropdown = new \PHPFUI\DropDown($toggleDropdownButton, $panel);
		$container->add($toggleDropdown);

		$hoverDropdownButton = new \PHPFUI\Button('Hoverable Dropdown');
		$panel = new \PHPFUI\HTML5Element('div');
		$panel->add('Just some junk that needs to be said. Or not. Your choice.');

		$hoverDropdown = new \PHPFUI\DropDown($hoverDropdownButton, $panel);
		$hoverDropdown->setHover();
		$container->add($hoverDropdown);

		return $container;
		}

	public function baseEqualizer() : Equalizer
		{
		$innerEqualizer = new \PHPFUI\Equalizer(new \PHPFUI\Callout());
		$co1 = new \PHPFUI\Callout('primary');
		$co1->add('This is a callout');
		$co2 = new \PHPFUI\Callout('warning');
		$co2->add('Warning Will Robinson');
		$co3 = new \PHPFUI\Callout('error');
		$co3->add('Stack Overflow with much more text and it just keeps going and going.  I wish there was some way to autogenerate text in PHP.');
		$innerEqualizer->addElement($co1);
		$innerEqualizer->addElement($co2);
		$innerEqualizer->addElement($co3);

		$equalizer = new \PHPFUI\Equalizer();
		$co2 = new \PHPFUI\Callout();
		$co2->add('This is a callout with much more text and it just keeps going and going.  I wish there was some way to autogenerate text in PHP.');
		$co3 = new \PHPFUI\Callout();
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
		$container = new \PHPFUI\Container();

		$label = new \PHPFUI\Label('Primary Label');
		$label->addClass('primary');
		$container->add($label);

		$label = new \PHPFUI\Label('Secondary Label');
		$label->addClass('secondary');
		$container->add($label);

		$label = new \PHPFUI\Label('Success Label');
		$label->addClass('success');
		$container->add($label);

		$label = new \PHPFUI\Label('Alert Label');
		$label->addClass('alert');
		$container->add($label);

		$label = new \PHPFUI\Label('Warning Label');
		$label->addClass('warning');
		$container->add($label);

		return $container;
		}

	public function baseMenu() : Container
		{
		$container = new \PHPFUI\Container();

		$container->add($this->makeMenu(new \PHPFUI\Menu(), 'Menu'));
		$container->add($this->makeMenu(new \PHPFUI\Menu(), 'Menu Right', 'align-right'));
		$container->add($this->makeMenu(new \PHPFUI\Menu(), 'Menu Center', 'align-center'));
		$container->add($this->makeMenu(new \PHPFUI\Menu(), 'Menu Expanded', 'expanded'));
		$container->add($this->makeMenu(new \PHPFUI\Menu(), 'Menu Vertical', 'vertical'));
		$container->add($this->makeMenu(new \PHPFUI\Menu(), 'Menu Vertical Right', 'vertical align-right'));
		$container->add($this->makeMenu(new \PHPFUI\Menu(), 'Menu Vertical Center', 'vertical align-center'));
		$container->add($this->makeMenu(new \PHPFUI\Menu(), 'Menu Simple', 'simple'));

		return $container;
		}

	public function baseOffCanvas() : Container
		{
		$container = new \PHPFUI\Container();

		$main = new \PHPFUI\HTML5Element('div');
		$main->add('This is the main content for the off canvas');

		$offCanvas = new \PHPFUI\OffCanvas($main);

		$off = new \PHPFUI\HTML5Element('div');
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

		$toggle = new \PHPFUI\Button('Toggle OffCanvas');
		$offCanvas->addOff($off, $toggle);

		$container->add($offCanvas);
		$container->add($toggle);

		return $container;
		}

	public function baseOrbit() : Orbit
		{
		$orbit = new \PHPFUI\Orbit('Some out of the world images');
		$orbit->addImageSlide(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/orbit/01.jpg'), 'Space, the final frontier.');
		$orbit->addImageSlide(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/orbit/02.jpg'), 'Lets Rocket!', true);
		$orbit->addImageSlide(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/orbit/03.jpg'), 'Encapsulating');
		$orbit->addImageSlide(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/orbit/04.jpg'), 'Outta This World');

		return $orbit;
		}

	public function baseOrderedList() : OrderedList
		{
		$orderedList = new \PHPFUI\OrderedList();
		$orderedList->addItem(new \PHPFUI\ListItem('Item 1'));
		$orderedList->addItem(new \PHPFUI\ListItem('Item 2'));
		$orderedList->addItem(new \PHPFUI\ListItem('Item 3'));

		return $orderedList;
		}

	public function baseProgressBar() : Container
		{
		$container = new \PHPFUI\Container();

		$bar = new \PHPFUI\ProgressBar();
		$bar->addClass('primary');
		$bar->setCurrent(25);
		$container->add($bar);

		$bar = new \PHPFUI\ProgressBar();
		$bar->addClass('warning');
		$bar->setCurrent(50);
		$container->add($bar);

		$bar = new \PHPFUI\ProgressBar();
		$bar->addClass('alert');
		$bar->setCurrent(75);
		$container->add($bar);

		$bar = new \PHPFUI\ProgressBar();
		$bar->addClass('success');
		$bar->setCurrent(100);
		$container->add($bar);

		return $container;
		}

	public function baseResponsiveEmbed() : Embed
		{
		$embed = new \PHPFUI\Embed();
		$embed->add(new \PHPFUI\YouTube('WUgvvPRH7Oc'));

		return $embed;
		}

	public function baseReveal() : Container
		{
		$container = new \PHPFUI\Container();

		$openButton = new \PHPFUI\Button('Click me for a modal');
		$container->add($openButton);

		$reveal = new \PHPFUI\Reveal($this->page, $openButton);
		$reveal->add(new \PHPFUI\Header('Awesome. I Have It.'));
		$reveal->add('<p class="lead">Your couch. It is mine.</p>');
		$reveal->add("<p>I'm a cool paragraph that lives inside of an even cooler modal. Wins!</p>");

		$nestedButton = new \PHPFUI\Button('Click me for a nested modal');
		$container->add($nestedButton);

		$nestedReveal = new \PHPFUI\Reveal($this->page, $nestedButton);
		$nestedReveal->add(new \PHPFUI\Header('Awesome!'));
		$nestedReveal->add('<p class="lead">I have another modal inside of me!</p>');

		$nestedRevealButton = new \PHPFUI\Button('Click me for another modal!');
		$nestedReveal->add($nestedRevealButton);

		$nestedReveal2 = new \PHPFUI\Reveal($this->page, $nestedRevealButton);
		$nestedReveal2->add(new \PHPFUI\Header('ANOTHER MODAL!!!'));

		return $container;
		}

	public function baseSlider() : Container
		{
		$container = new \PHPFUI\Container();

		$container->add(new \PHPFUI\Slider(25));

		$data = new \PHPFUI\Input('number', 'data');
		$slider = new \PHPFUI\Slider(12, new \PHPFUI\SliderHandle(12, $data));
		$slider->setVertical();
		$container->add($slider);
		$container->add($data);

		$firstHandle = new \PHPFUI\Input('number', 'first');
		$secondHandle = new \PHPFUI\Input('number', 'second');
		$slider = new \PHPFUI\Slider(25, new \PHPFUI\SliderHandle(25, $firstHandle));
		$slider->setRangeHandle(new \PHPFUI\SliderHandle(75, $secondHandle));
		$container->add($slider);
		$container->add($firstHandle);
		$container->add($secondHandle);

		return $container;
		}

	public function baseSplitButton() : SplitButton
		{
		$splitButton = new \PHPFUI\SplitButton('Split', '#');
		$splitButton->addMenuItem(new \PHPFUI\MenuItem('Option 4', '#'));
		$splitButton->addMenuItem(new \PHPFUI\MenuItem('Option 3', '#'));
		$splitButton->addMenuItem(new \PHPFUI\MenuItem('Option 5', '#'));
		$splitButton->addMenuItem(new \PHPFUI\MenuItem('Option 1', '#'));
		$splitButton->addMenuItem(new \PHPFUI\MenuItem('Option 2', '#'));
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
		$container = new \PHPFUI\Container();

		$switchCB = new \PHPFUI\Input\SwitchCheckBox('name', true, 'Do you like me?');
		$switchCB->setActiveLabel('Yes')->setInactiveLabel('No')->addClass('large');
		$container->add($switchCB);

		return $container;
		}

	public function baseSwitchRadio() : Container
		{
		$container = new \PHPFUI\Container();

		$switchRB1 = new \PHPFUI\Input\SwitchRadio('radio', 1);
		$switchRB1->setActiveLabel('Yes')->setInactiveLabel('No')->addClass('large');
		$container->add($switchRB1);

		$switchRB2 = new \PHPFUI\Input\SwitchRadio('radio', 2);
		$container->add($switchRB2->setChecked());

		$switchRB3 = new \PHPFUI\Input\SwitchRadio('radio', 3);
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
		$table->setFooters(\array_combine($headers, $headers));

		for ($i = 0; $i < 10; ++$i)
			{
			$numbers = [];

			foreach ($headers as $field)
				{
				$numbers[$field] = \random_int(0, \mt_getrandmax());
				}

			$numbers['Edit'] = new \PHPFUI\Input\Text('edit[]');
			$numbers['CheckBox'] = new \PHPFUI\Input\CheckBox('check[]');
			$table->addRow($numbers);
			}

		return $table;
		}

  public function baseTabs() : Container
	{
	$container = new \PHPFUI\Container();

	$tabs = new \PHPFUI\Tabs();
	$tabs->addTab('One', 'Check me out! I\'m a super cool Tab panel with text content!');
	$image = new \PHPFUI\Image('/images/rectangle-1.jpg');
	$tabs->addTab('Two', $image);
	$tabs->addTab('Three', '', true);
	$tabs->addTab('Four', $image);
	$container->add($tabs);

	$grid = new \PHPFUI\GridX();
	$grid->setMargin();
	$cell = new \PHPFUI\Cell(3, 2, 1);
	$vtabs = new \PHPFUI\Tabs(true);
	$vtabs->addTab('One', 'Check me out! I\'m VERTICAL!');
	$vtabs->addTab('Two', $image);
	$vtabs->addTab('Three', '', true);
	$vtabs->addTab('Four', $image);
	$cell->add($vtabs->getTabs());
	$grid->add($cell);
	$content = new \PHPFUI\Cell();
	$content->add($vtabs->getContent());
	$grid->add($content);
	$gridContainer = new \PHPFUI\GridContainer();
	$gridContainer->add($grid);
	$container->add($gridContainer);

	return $container;
	}

	public function baseThumbnail() : Container
		{
		$container = new \PHPFUI\Container();

		$container->add(new \PHPFUI\Thumbnail(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/thumbnail/01.jpg')));
		$container->add(new \PHPFUI\Thumbnail(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/thumbnail/02.jpg')));
		$container->add(new \PHPFUI\Thumbnail(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/thumbnail/03.jpg')));

		return $container;
		}

	public function baseTitleBar() : TitleBar
		{
		$titlebar = new \PHPFUI\TitleBar('TitleBar');
		$titlebar->addLeft('<button class="menu-icon" type="button"></button>');
		$titlebar->addRight('<button class="menu-icon" type="button"></button>');

		return $titlebar;
		}

	public function baseToggler() : Container
		{
		$container = new \PHPFUI\Container();

		$toggleAll = new \PHPFUI\Button('Toggle All These');

		$image1 = new \PHPFUI\Thumbnail(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/thumbnail/01.jpg'));
		$image2 = new \PHPFUI\Thumbnail(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/thumbnail/02.jpg'));
		$image3 = new \PHPFUI\Thumbnail(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/thumbnail/03.jpg'));

		$toggleAll->toggleAnimate($image1, 'hinge-in-from-left spin-out');
		$toggleAll->toggleAnimate($image2, 'hinge-in-from-bottom fade-out');
		$toggleAll->toggleAnimate($image3, 'slide-in-down slide-out-up');

		$container->add(new \PHPFUI\MultiColumn($toggleAll));
		$container->add($image1);
		$container->add($image2);
		$container->add($image3);

		$toggleFocus = new \PHPFUI\Input\Text('test', 'Toggle on Focus');

		$callout = new \PHPFUI\Callout('secondary');
		$callout->add('<p>This is only visible when the above field has focus.</p>');

		$toggleFocus->toggleFocus($callout);

		$container->add(new \PHPFUI\MultiColumn($toggleFocus));
		$container->add($callout);

		return $container;
		}

	public function baseToolTip() : Container
		{
		$container = new \PHPFUI\Container();

		$toolTip = new \PHPFUI\ToolTip('scarabaeus', 'Fancy word for a beetle');
		$container->add("<p>The {$toolTip} hung quite clear of any branches, and, if allowed to fall, would have fallen at our feet. Legrand immediately took the scythe, and cleared with it a circular space, three or four yards in diameter, just beneath the insect, and, having accomplished this, ordered Jupiter to let go the string and come down from the tree.</p>");

		return $container;
		}

	public function baseTopBar() : TopBar
		{
		$topbar = new \PHPFUI\TopBar();
		$topbar->addLeft($this->makeMenu(new \PHPFUI\DropDownMenu(), 'Site Title', '', $this->subMenu()));

		$menu = new \PHPFUI\Menu();
		$search = new \PHPFUI\Input('search', '');
		$search->addAttribute('placeholder', 'Search');
		$menu->addMenuItem(new \PHPFUI\MenuItem($search));
		$menu->addMenuItem(new \PHPFUI\MenuItem(new \PHPFUI\Button('Search')));
		$topbar->addRight($menu);

		return $topbar;
		}

	public function baseUnorderedList() : UnorderedList
		{
		$unorderedList = new \PHPFUI\UnorderedList();
		$unorderedList->addItem(new \PHPFUI\ListItem('Item'));
		$unorderedList->addItem(new \PHPFUI\ListItem('Item 1'));
		$unorderedList->addItem(new \PHPFUI\ListItem('Item C'));

		return $unorderedList;
		}

	public function extraDebug() : Container
		{
		$container = new \PHPFUI\Container();

		$container->add(new \PHPFUI\Debug($this, 'Debug $this!'));

		return $container;
		}

	public function extraIcon() : Container
		{
		$container = new \PHPFUI\Container();

		$iconPlain = new \PHPFUI\Icon('edit');
		$container->add($iconPlain);
		$iconPlainTip = new \PHPFUI\Icon('edit');
		$iconPlainTip->setTooltip('I am a plain icon with a tooltip');
		$container->add($iconPlainTip);
		$iconLink = new \PHPFUI\Icon('edit', '#');
		$container->add($iconLink);
		$iconLinkTip = new \PHPFUI\Icon('edit', '#');
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
		$table->setFooters(\array_combine($headers, $headers));

		for ($i = 0; $i < 10; ++$i)
			{
			$numbers = [];

			foreach ($headers as $field)
				{
				$numbers[$field] = \random_int(0, \mt_getrandmax());
				}

			$numbers['Edit'] = new \PHPFUI\Input\Text('edit[]');
			$numbers['CheckBox'] = new \PHPFUI\Input\CheckBox('check[]');
			$table->addRow($numbers);
			}

		return $table;
		}

	public function extraPagination() : Pagination
		{
		$pagination = new \PHPFUI\Pagination(50, 100, '#');

		return $pagination;
		}

	public function extraPanel() : Panel
		{
		$panel = new \PHPFUI\Panel('This is a panel with a radius');
		$panel->setRadius();

		return $panel;
		}

	public function extraSlickSlider() : SlickSlider
		{
		$slickSlider = new \PHPFUI\SlickSlider($this->page);
		$slickSlider->addImage('https://foundation.zurb.com/sites/docs/assets/img/orbit/01.jpg', 'Space, the final frontier.');
		$slickSlider->addImage('https://foundation.zurb.com/sites/docs/assets/img/orbit/02.jpg', 'Lets Rocket!');
		$slickSlider->addImage('https://foundation.zurb.com/sites/docs/assets/img/orbit/03.jpg', 'Encapsulating');
		$slickSlider->addImage('https://foundation.zurb.com/sites/docs/assets/img/orbit/04.jpg', 'Outta This World');

		return $slickSlider;
		}

	public function extraSubHeader() : \PHPFUI\SubHeader
		{
		$subHeader = new \PHPFUI\SubHeader('Sub Header');

		return $subHeader;
		}

	public function extraTimedCellUpdate() : HTML5Element
		{
		$div = new \PHPFUI\HTML5Element('div');

		$timedCellUpdate = new \PHPFUI\TimedCellUpdate($this->page, $div->getId(), [$this, 'timedCellUpdateCallback'], 1);

		return $div;
		}

	public function extraToFromList() : ToFromList
		{
		$index = 'id';
		$callback = [$this, 'getToFromListName'];
		$split = \random_int(0, \count($this->lines) - 1);
		$notInGroup = \array_slice($this->lines, $split);
		$inGroup = \array_slice($this->lines, 0, $split);
		$toFromList = new \PHPFUI\ToFromList($this->page, 'groups', $inGroup, $notInGroup, $index, $callback);
		$toFromList->setInName('In Group');
		$toFromList->setOutName('Out Group');

		return $toFromList;
		}

	/**
	 * Get all the example functions
	 *
	 * @return array<string, string> of method names indexed by English name
	 */
	public function getExamples(string $prefix = 'base') : array
		{
		$examples = [];

		$prefixLen = \strlen($prefix);
		$methods = \get_class_methods(self::class);

		foreach ($methods as $methodName)
			{
			if (\str_starts_with($methodName, $prefix))
				{
				$name = \substr($methodName, $prefixLen);
				$examples[$name] = $methodName;
				}
			}

		return $examples;
		}

	public function getToFromListName(string $fieldName, string $indexName, string $index, string $type) : string
		{
		$line = $this->lines[$index];
		$hidden = new \PHPFUI\Input\Hidden($type . $fieldName . '[]', $line[$indexName]);

		return (string)$hidden . $line['name'];
		}

	public function render(string $type = 'base') : string
		{
		$container = new \PHPFUI\Container();

		$examples = $this->getExamples($type);

		\ksort($examples);

		$hr = '';
		$realHr = new \PHPFUI\HTML5Element('hr');

		foreach ($examples as $name => $example)
			{
			$container->add($hr);
			$container->add(new \PHPFUI\Header($name, 3));
			$container->add($this->{$example}());

			if ($this->page->isDone())
				{
				return '';
				}

			$hr = $realHr;
			}

		return (string)$container;
		}

	public function timedCellUpdateCallback(string $id) : string
		{
		return \gmdate('H:i:s') . ' ' . $id;
		}

	private function generateMenu(string $name, int $count, bool $active = false) : Menu
		{
		$names = ['One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten'];
		$menu = new \PHPFUI\Menu();
		$count = \min($count, 10);

		for ($i = 0; $i < $count; ++$i)
			{
			$item = new \PHPFUI\MenuItem($names[$i] . ' ' . $name, '#');
			$item->setActive($active);
			$active = false;
			$menu->addMenuItem($item);
			}

		return $menu;
		}

	private function makeMenu(Menu $menu, string $name, ?string $class = '', ?\PHPFUI\Menu $subMenu = null) : Menu
		{
		$menu->addMenuItem(new \PHPFUI\MenuItem($name));
		$menu->addMenuItem(new \PHPFUI\MenuItem('One', '#'));
		$menu->addMenuItem(new \PHPFUI\MenuItem('Two', '#'));
		$three = new \PHPFUI\MenuItem('Three', '#');

		if ($subMenu)
			{
			$menu->addSubMenu($three, $subMenu);
			}
		else
			{
			$three->setActive(true);
			$menu->addMenuItem($three);
			}

		$menu->addMenuItem(new \PHPFUI\MenuItem('Four', '#'));

		if ($class)
			{
			$menu->addClass($class);
			}

		return $menu;
		}

	private function section(string $name) : Container
		{
		$container = new \PHPFUI\Container();

		$container->add(new \PHPFUI\HTML5Element('hr'));
		$container->add(new \PHPFUI\Header($name, 2));

		return $container;
		}

	private function subMenu() : Menu
		{
		$menu = new \PHPFUI\Menu();
		$menu->addMenuItem(new \PHPFUI\MenuItem('One A', '#'));
		$menu->addMenuItem(new \PHPFUI\MenuItem('Two A', '#'));
		$menu->addMenuItem(new \PHPFUI\MenuItem('Three A', '#'));
		$menu->addSubMenu(new \PHPFUI\MenuItem('Four A', '#'), $this->generateMenu('B', 3, true));
		$menu->addSubMenu(new \PHPFUI\MenuItem('Five A', '#'), $this->generateMenu('C', 10));

		return $menu;
		}
	}
