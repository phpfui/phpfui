<?php

namespace PHPFUI;

include '../common.php';

class Section extends Container
  {

  public function __construct(string $header)
    {
    $this->add(new \PHPFUI\HTML5Element('hr'));
    $this->add(new \PHPFUI\Header($header, 2));
    }

  }

function generateMenu(string $name, int $count, bool $active = false) : Menu
  {
  $names = ['One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten'];
  $menu = new Menu();
  for ($i = 0; $i < $count; ++$i) {
      $item = new MenuItem($names[$i].' '.$name, '#');
      $item->setActive($active);
      $active = false;
      $menu->addMenuItem($item);
  }

  return $menu;
  }

function getSubMenu() : Menu
  {
  $menu = new Menu();
  $menu->addMenuItem(new MenuItem('One A', '#'));
  $menu->addMenuItem(new MenuItem('Two A', '#'));
  $menu->addMenuItem(new MenuItem('Three A', '#'));
  $menu->addSubMenu(new MenuItem('Four A', '#'), generateMenu('B', 3, true));
  $menu->addSubMenu(new MenuItem('Five A', '#'), generateMenu('C', 10));

  return $menu;
  }

function makeMenu(Menu $menu, string $name, ?string $class = '', ?Menu $subMenu = null) : Menu
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

try
  {
  $page = new Page();
  $page->addHeadScript('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/motion-ui@1.2.3/dist/motion-ui.min.css" />');
  $page->addStyleSheet('/css/style.css');

  $page->add(new Header('Kitchen Sink'));
  $page->add(new Header('Everything but.', 5));

  $page->add(new Section('Abide'));

  $page->add(new Section('Accordion'));

  $accordion = new Accordion();
  $accordion->addTab('Accordion 1', 'some text');
  $accordion->addTab('Accordion 2', 'more some text');
  $accordion->addTab('Accordion 3', 'even more text text');
  $page->add($accordion);

  $page->add(new Section('Accordion Menu'));

  $page->add(makeMenu(new AccordionMenu(), 'Accordion Menu', '', getSubMenu()));

  $page->add(new Section('Badge'));
  $primaryBadge = new Badge('1');
  $primaryBadge->addClass('primary');
  $page->add($primaryBadge);

  $secondaryBadge = new Badge('2');
  $secondaryBadge->addClass('secondary');
  $page->add($secondaryBadge);

  $successBadge = new Badge('3');
  $successBadge->addClass('success');
  $page->add($successBadge);

  $alertBadge = new Badge('A');
  $alertBadge->addClass('alert');
  $page->add($alertBadge);

  $warningBadge = new Badge('B');
  $warningBadge->addClass('warning');
  $page->add($warningBadge);

  $page->add(new Section('BreadCrumbs'));

  $BreadCrumbs = new BreadCrumbs();
  $BreadCrumbs->addCrumb('Home', '#');
  $BreadCrumbs->addCrumb('Features', '#');
  $BreadCrumbs->addCrumb('Gene Splicing');
  $BreadCrumbs->addCrumb('Cloning');
  $page->add($BreadCrumbs);

  $page->add(new Section('Button'));

  $page->add(new Button('Learn More', '#0'));
  $page->add(new Button('View All Features', '#features'));

  $save = new Button('Save');
  $save->addClass('success');
  $page->add($save);

  $save = new Button('Delete');
  $save->addClass('alert');
  $page->add($save);

  $tiny = new Button('So Tiny', '#0');
  $tiny->addClass('tiny');
  $page->add($tiny);

  $small = new Button('So Small', '#0');
  $small->addClass('small');
  $page->add($small);

  $large = new Button('So Large', '#0');
  $large->addClass('large');
  $page->add($large);

  $expand = new Button('Such Expand', '#0');
  $expand->addClass('expanded');
  $page->add($expand);

  $group = new ButtonGroup();
  $group->addButton(new Button('One'));
  $group->addButton(new Button('Two'));
  $group->addButton(new Button('Three'));
  $page->add($group);

  $page->add(new Section('Callout'));

  foreach (['', 'primary', 'secondary', 'success', 'warning', 'alert'] as $type)
    {
    $callout = new Callout($type);
    $callout->add("<h5>This is a {$type} callout.</h5><p>It has an easy to override visual style, and is appropriately subdued.</p><a href='#'>It's dangerous to go alone, take this.</a>");
    $page->add($callout);
    }

  $page->add(new Section('Card'));

  $card = new Card();
  $card->addDivider(new Header("I'm featured", 4));
  $card->addImage('<img src="/images/rectangle-1.jpg">');
  $card->addSection('This card makes use of the card-divider element.');
  $page->add($card);

  $page->add(new Section('Close Button'));

  $closeBox = new Callout();
  $close = new CloseButton($closeBox);
  $closeBox->add('<p>You can so totally close this!</p>');
  $closeBox->add($close);
  $page->add($closeBox);

  $closeBox = new Callout();
  $closeBox->addClass('success');
  $close = new CloseButton($closeBox, 'slide-out-right');
  $closeBox->add('<p>You can close me too, and I close using a Motion UI animation.</p>');
  $closeBox->add($close);
  $page->add($closeBox);

  $page->add(new Section('Drilldown Menu'));

  $page->add(makeMenu(new DrillDownMenu(), 'Drill Down Menu', '', getSubMenu()));

  $drillDown = makeMenu(new DrillDownMenu(), 'Drill Down Menu Auto Height', '', getSubMenu());
  $drillDown->setAutoHeight();
//  $drillDown->setAnimateHeight();

  $page->add($drillDown);

	$page->add(new Section('Dropdown Button'));

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

	$page->add($dropDown);

  $page->add(new Section('Dropdown Menu'));

  $page->add(makeMenu(new DropDownMenu(), 'Drop Down Menu', '', getSubMenu()));
  $dropDown = makeMenu(new DropDownMenu(), 'Drop Down Menu Vertical', 'vertical', getSubMenu());
	$dropDown->computeWidth();
  $page->add($dropDown);

  $page->add(new Section('Dropdown Pane'));

  $toggleDropdownButton = new Button('Toggle Dropdown');
  $panel = new HTML5Element('div');
  $panel->add('Just some junk that needs to be said. Or not. Your choice.');

  $toggleDropdown = new Dropdown($toggleDropdownButton, $panel);
  $page->add($toggleDropdown);

  $hoverDropdownButton = new Button('Hoverable Dropdown');
  $panel = new HTML5Element('div');
  $panel->add('Just some junk that needs to be said. Or not. Your choice.');

  $hoverDropdown = new Dropdown($hoverDropdownButton, $panel);
  $hoverDropdown->setHover();
  $page->add($hoverDropdown);

  $page->add(new Section('Equalizer'));

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
  $page->add($equalizer);

  $page->add(new Section('Responsive Embed'));

  $page->add(new Embed(new YouTube('WUgvvPRH7Oc')));

  $page->add(new Section('Float Classes'));

  $page->add(new Section('Forms'));

  $page->add(new Section('Grid'));

  $page->add(new Section('Interchange'));

  $page->add(new Section('Label'));

  $label = new Label('Primary Label');
  $label->addClass('primary');
  $page->add($label);

  $label = new Label('Secondary Label');
  $label->addClass('secondary');
  $page->add($label);

  $label = new Label('Success Label');
  $label->addClass('success');
  $page->add($label);

  $label = new Label('Alert Label');
  $label->addClass('alert');
  $page->add($label);

  $label = new Label('Warning Label');
  $label->addClass('warning');
  $page->add($label);

  $page->add(new Section('Magellan'));

  $page->add(new Section('Media Object'));

  $page->add(new Section('Menu'));

  $page->add(makeMenu(new Menu(), 'Menu'));
  $page->add(makeMenu(new Menu(), 'Menu Right', 'align-right'));
  $page->add(makeMenu(new Menu(), 'Menu Center', 'align-center'));
  $page->add(makeMenu(new Menu(), 'Menu Expanded', 'expanded'));
  $page->add(makeMenu(new Menu(), 'Menu Vertical', 'vertical'));
  $page->add(makeMenu(new Menu(), 'Menu Vertical Right', 'vertical align-right'));
  $page->add(makeMenu(new Menu(), 'Menu Vertical Center', 'vertical align-center'));
  $page->add(makeMenu(new Menu(), 'Menu Simple', 'simple'));

  $page->add(new Section('Off-canvas'));

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

  $offId = $offCanvas->addOff($off, $toggle);

  $page->add($offCanvas);
  $page->add($toggle);

  $page->add(new Section('Orbit'));

  $orbit = new Orbit('Some out of the world images');
  $orbit->addImageSlide(new Image('/images/slide-01.webp'), 'Space, the final frontier.');
  $orbit->addImageSlide(new Image('/images/slide-02.webp'), 'Lets Rocket!', true);
  $orbit->addImageSlide(new Image('/images/slide-03.webp'), 'Encapsulating');
  $orbit->addImageSlide(new Image('/images/slide-04.webp'), 'Outta This World');
  $page->add($orbit);

  $page->add(new Section('Pagination'));

  $pagination = new Pagination(1, 10, '#');
  $page->add($pagination);

  $page->add(new Section('Progress Bar'));

  $bar = new ProgressBar();
  $bar->addClass('primary');
  $bar->setCurrent(25);
  $page->add($bar);

  $bar = new ProgressBar();
  $bar->addClass('warning');
  $bar->setCurrent(50);
  $page->add($bar);

  $bar = new ProgressBar();
  $bar->addClass('alert');
  $bar->setCurrent(75);
  $page->add($bar);

  $bar = new ProgressBar();
  $bar->addClass('success');
  $bar->setCurrent(100);
  $page->add($bar);

  $page->add(new Section('Responsive Menu'));

  $page->add(new Section('Responsive Toggle'));

  $page->add(new Section('Reveal'));

  $openButton = new Button('Click me for a modal');
  $page->add($openButton);

  $reveal = new Reveal($page, $openButton);
  $reveal->add(new Header('Awesome. I Have It.'));
  $reveal->add('<p class="lead">Your couch. It is mine.</p>');
  $reveal->add("<p>I'm a cool paragraph that lives inside of an even cooler modal. Wins!</p>");

  $nestedButton = new Button('Click me for a nested modal');
  $page->add($nestedButton);

  $nestedReveal = new Reveal($page, $nestedButton);
  $nestedReveal->add(new Header('Awesome!'));
  $nestedReveal->add('<p class="lead">I have another modal inside of me!</p>');

  $nestedRevealButton = new Button('Click me for another modal!');
  $nestedReveal->add($nestedRevealButton);

  $nestedReveal2 = new Reveal($page, $nestedRevealButton);
  $nestedReveal2->add(new Header('ANOTHER MODAL!!!'));

  $page->add(new Section('Slider'));

  $page->add(new Slider($page, 25));

  $data = new Input('number', 'data');
  $slider = new Slider($page, 12, new SliderHandle(12, $data));
  $slider->setVertical();
  $page->add($slider);
  $page->add($data);

  $firstHandle = new Input('number', 'first');
  $secondHandle = new Input('number', 'second');
  $slider = new Slider($page, 25, new SliderHandle(25, $firstHandle));
  $slider->setRangeHandle(new SliderHandle(75, $secondHandle));
  $page->add($slider);
  $page->add($firstHandle);
  $page->add($secondHandle);


	$page->add(new Section($name = 'Split Button'));

	$splitButton = new SplitButton($name, '#');
	$splitButton->addMenuItem(new MenuItem('Option 4', '#'));
	$splitButton->addMenuItem(new MenuItem('Option 3', '#'));
	$splitButton->addMenuItem(new MenuItem('Option 5', '#'));
	$splitButton->addMenuItem(new MenuItem('Option 1', '#'));
	$splitButton->addMenuItem(new MenuItem('Option 2', '#'));
	$splitButton->sort();

	$page->add($splitButton);

//  $page->add(new Section('Sticky'));
//
//  $parent = new GridX();
//  $parent->setMargin();
//  $leftSide = new Cell(6);
//  $leftSide->add('<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>');
//  $leftSide->add('<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>');
//  $leftSide->add('<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>');
//  $leftSide->add('<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>');
//  $parent->add($leftSide);
//  $rightSide = new Cell(6);
//  $sticky = new Sticky($rightSide);
//  $sticky->add('<b>This should be sticky</b?');
//  $rightSide->add($sticky);
//  $parent->add($rightSide);
//
//  $page->add($parent);

  $page->add(new Section('Switch'));

  $switchCB = new \PHPFUI\Input\SwitchCheckBox('name', true, 'Do you like me');
  $switchCB->setActiveLabel('Yes')->setInactiveLabel('No')->addClass('large');
  $page->add($switchCB);

  $switchRB1 = new \PHPFUI\Input\SwitchRadio('radio', 1);
  $switchRB1->setActiveLabel('Yes')->setInactiveLabel('No')->addClass('large');
  $page->add($switchRB1);

  $switchRB2 = new \PHPFUI\Input\SwitchRadio('radio', 2);
  $page->add($switchRB2->setChecked());

  $switchRB3 = new \PHPFUI\Input\SwitchRadio('radio', 3);
  $page->add($switchRB3->addClass('tiny'));

  $page->add(new Section('Table'));

  $page->add(new Section('Tabs'));

  $tabs = new Tabs();
  $tabs->addTab('One', 'Check me out! I\'m a super cool Tab panel with text content!');
  $tabs->addTab('Two', '<img src="/images/rectangle-1.jpg">');
  $tabs->addTab('Three', '', true);
  $tabs->addTab('Four', '<img src="/images/rectangle-1.jpg">');
  $page->add($tabs);

  $grid = new GridX();
  $grid->setMargin();
  $cell = new Cell(3, 2, 1);
  $vtabs = new Tabs(true);
  $vtabs->addTab('One', 'Check me out! I\'m VERTICAL!');
  $vtabs->addTab('Two', '<img src="/images/rectangle-1.jpg">');
  $vtabs->addTab('Three', '', true);
  $vtabs->addTab('Four', '<img src="/images/rectangle-1.jpg">');
  $cell->add($vtabs->getTabs());
  $grid->add($cell);
  $content = new Cell();
  $content->add($vtabs->getContent());
  $grid->add($content);
  $gridContainer = new GridContainer();
  $gridContainer->add($grid);
  $page->add($gridContainer);

  $page->add(new Section('Thumbnail'));

  $page->add(new Thumbnail(new Image('/images/rectangle-1.jpg')));
  $page->add(new Thumbnail(new Image('/images/FB-f-Logo__blue_50.png'), '#'));

  $page->add(new Section('Title Bar'));

  $titlebar = new TitleBar('TitleBar');
  $titlebar->addLeft('<button class="menu-icon" type="button"></button>');
  $titlebar->addRight('<button class="menu-icon" type="button"></button>');
  $page->add($titlebar);

  $page->add(new Section('Toggler'));

  $toggleAll = new Button('Toggle All These');

  $image1 = new Thumbnail(new Image('/images/rectangle-1.jpg'));
  $image2 = new Thumbnail(new Image('/images/FB-f-Logo__blue_50.png'));
  $image3 = new Thumbnail(new Image('/images/Twitter_Logo_White_On_Blue.png'));

  $toggleAll->toggleAnimate($image1, 'hinge-in-from-left spin-out');
  $toggleAll->toggleAnimate($image2, 'hinge-in-from-bottom fade-out');
  $toggleAll->toggleAnimate($image3, 'slide-in-down slide-out-up');

  $page->add(new MultiColumn($toggleAll));
  $page->add($image1);
  $page->add($image2);
  $page->add($image3);

  $toggleFocus = new Input\Text('test', 'Toggle on Focus');

  $image1 = new Thumbnail(new Image('/images/rectangle-1.jpg'));

  $toggleFocus->toggleFocus($image1, 'hinge-in-from-left spin-out');

  $page->add(new MultiColumn($toggleFocus));
  $page->add($image1);

  $page->add(new Section('Tooltip'));

  $toolTip = new ToolTip('scarabaeus', 'Fancy word for a beetle');

  $page->add("<p>The {$toolTip} hung quite clear of any branches, and, if allowed to fall, would have fallen at our feet. Legrand immediately took the scythe, and cleared with it a circular space, three or four yards in diameter, just beneath the insect, and, having accomplished this, ordered Jupiter to let go the string and come down from the tree.</p>");

  $page->add(new Section('Top Bar'));

  $topbar = new TopBar();
  $topbar->addLeft('<ul class="dropdown menu" data-dropdown-menu>
      <li class="menu-text">Site Title</li>
      <li>
        <a href="#">One</a>
        <ul class="menu vertical">
          <li><a href="#">One</a></li>
          <li><a href="#">Two</a></li>
          <li><a href="#">Three</a></li>
        </ul>
      </li>
      <li><a href="#">Two</a></li>
      <li><a href="#">Three</a></li>
    </ul>');
  $topbar->addRight('<ul class="menu">
      <li><input type="search" placeholder="Search"></li>
      <li><button type="button" class="button">Search</button></li>
    </ul>');
  $page->add($topbar);

  echo $page;
  }
catch (Throwable $e)
  {
  echo $e->message;
  }

