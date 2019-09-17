<?php

namespace PHPFUI;

// Your autoloader here
include '../common.php';

try
  {
  $page = new Page();
	// For motion UI, not added by default, or generate locally with Foundation
  $page->addStyleSheet('https://cdn.jsdelivr.net/npm/motion-ui@1.2.3/dist/motion-ui.min.css');
	// You need a reasonable style sheet as well.  Default Foundation will work.
  $page->addStyleSheet('/css/style.css');

  $kitchenSink = new KitchenSink($page);

  $mainColumn = new \PHPFUI\Cell(12);
  $mainColumn->addClass('main-column');
	$mainColumn->add(new Header('Kitchen Sink'));
	$mainColumn->add(new Header('Everything but.', 5));

  $mainColumn->add($kitchenSink->render());
  $page->add($mainColumn);

  echo $page;
  }
catch (Throwable $e)
  {
  echo "<h1>OPPS!</h1><pre>";
	print_r($e);
  }
