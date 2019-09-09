<?php

namespace PHPFUI;

include '../common.php';

$page = new Page();
$page->addStyleSheet('/css/style.css');

$p = $_GET['p'] ?? 1;
$w = $_GET['w'] ?? 3;
$o = $_GET['o'] ?? 10;
$ff = $_GET['ff'] ?? 0;
$c = $_GET['c'] ?? false;

$paginate = new Pagination($p, $o, "/paginate.php?p=~page~&o={$o}&ff={$ff}&c={$c}&w={$w}");
if ($c)
  {
  $paginate->center();
  }
$paginate->setFastForward($ff);
$paginate->setWindow($w);
$page->add($paginate);
//echo $page;

$form = new Form($page);
$fieldSet = new FieldSet('Change Parameters');
$of = new \PHPFUI\Input\Number('o', 'Total Pages', $o);
$of->setToolTip('Total pages in view');
$window = new \PHPFUI\Input\Number('w', 'Page Window', $w);
$window->setToolTip('Page window on either side of current page');
$fastForward = new \PHPFUI\Input\Number('ff', 'Fast Forward', $ff);
$fastForward->setToolTip('Pages to advance instead of elipse');
$center = new \PHPFUI\Input\CheckBoxBoolean('c', 'Center', $c);
$center->setToolTip('Check to center the paginator');
$mc = new MultiColumn($of, $window, $fastForward, $center);
$mc->addClass('align-center-middle');

$fieldSet->add($mc);
$form->add($fieldSet);
$form->add(new Submit('Change'));
$form->setAttribute('method', 'GET');
$page->add($form);
echo $page;
