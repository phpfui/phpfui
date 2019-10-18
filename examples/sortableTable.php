<?php

namespace PHPFUI;

include '../vendor/autoload.php';

$page = new Page();
// You need a reasonable style sheet as well.  Default Foundation will work.
$page->addStyleSheet('/css/style.css');

$mainColumn = new Cell(12);
$mainColumn->addClass('main-column');
$mainColumn->add(new Header('SortableTable Example'));

$table = new SortableTable();

// get the parameter we know we are interested in
$parameters = $table->getParsedParameters();
$p = (int)($parameters['p'] ?? 0);
$limit = (int)($parameters['l'] ?? 25);
$column = $parameters['c'] ?? 'Sequence';
$sort = $parameters['s'] ?? 'a';

$headers = ['s' => 'Sequence', 'r' => 'Random'];
$table->setHeaders($headers)->setSortableColumns(array_keys($headers))->setSortedColumnOrder($column, $sort);

$count = 10000;
$lastPage = (int)($count / $limit);
if ($p >= 0 && $p < $lastPage)
	{
	// generate data
	$data = [];
	for ($i = 0; $i < $count; ++$i)
		{
		srand($i); // always use a known seed per position
		$data[] = ['s' => $i, 'r' => rand()];
		}

	// do the sort, data in Sequence ascending already, so only do if not that
	if ($column != 's' || $sort != 'a')
		{
		// very much hard coded and not generic, but this is just a demo
		if ($column == 's')
			{
			usort($data, function($a, $b) { return $b['s'] > $a['s']; });
			}
		else if ($sort == 'a')
			{
			usort($data, function($a, $b) { return $b['r'] < $a['r']; });
			}
		else
			{
			usort($data, function($a, $b) { return $b['r'] > $a['r']; });
			}
		}

	// add selected data to table
	$start = $p * $limit;
	$end = $start + $limit;
	for ($i = $start; $i < $end; ++$i)
		{
		$table->addRow($data[$i]);
		}

	$mainColumn->add($table);

	// set page to magic value for replacement
	$parameters['p'] = 'PAGE';
	$url = $table->getBaseUrl() . '?' . http_build_query($parameters);

	// Add the paginator to the bottom
	$paginator = new Pagination($p, $lastPage, $url);
	$paginator->center()->setFastForward(30)->setWindow(5);
	$mainColumn->add($paginator);
	}
else
	{
	$mainColumn->add(new SubHeader('Page not found'));
	}

$page->add($mainColumn);

echo $page;

