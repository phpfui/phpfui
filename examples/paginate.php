<?php

namespace PHPFUI;

// Your autoloader here
include '../vendor/autoload.php';

$page = new Page();
// You need a reasonable style sheet as well.  Default Foundation will work.
$page->addStyleSheet('/css/style.css');

$p = $_GET['p'] ?? 1;
$w = $_GET['w'] ?? 3;
$o = $_GET['o'] ?? 10;
$ff = $_GET['ff'] ?? 0;
$c = $_GET['c'] ?? false;

$mainColumn = new Cell(12);
$mainColumn->addClass('main-column');
$mainColumn->add(new Header('Pagination Tester'));

$paginate = new Pagination($p, $o, "/paginate.php?p=PAGE&o={$o}&ff={$ff}&c={$c}&w={$w}");
if ($c)
  {
  $paginate->center();
  }
$paginate->setFastForward($ff);
$paginate->setWindow($w);
$mainColumn->add($paginate);

$form = new Form($page);
$fieldSet = new FieldSet('Change Parameters');
$of = new Input\Number('o', 'Total Pages', $o);
$of->setToolTip('Total pages in view');
$window = new Input\Number('w', 'Page Window', $w);
$window->setToolTip('Number of pages to show on either side of current page');
$fastForward = new Input\Number('ff', 'Fast Forward', $ff);
$fastForward->setToolTip('Pages to advance instead of elipse');
$center = new Input\CheckBoxBoolean('c', 'Center', $c);
$center->setToolTip('Check to center the paginator');
$mc = new MultiColumn($of, $window, $fastForward, $center);
$mc->addClass('align-center-middle');

$fieldSet->add($mc);
$form->add($fieldSet);
$form->add(new Submit('Change'));
$form->setAttribute('method', 'GET');
$mainColumn->add($form);
$page->add($mainColumn);

echo $page;
