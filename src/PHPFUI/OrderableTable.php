<?php

namespace PHPFUI;

/**
 * Create a table that is orderable via drag and drop
 */
class OrderableTable extends \PHPFUI\Table
	{
	public function __construct(\PHPFUI\Interfaces\Page $page)
		{
		parent::__construct();
		$this->page = $page;
		$this->page->addTailScript('html5sortable.min.js');
		$this->sortableBodyClass = ' class="table-sortable"';
		$this->sortableTrClass = ' class="row-sortable"><td class="handle">' . \PHPFUI\Language::$updownarrow . '</td';
		}
	}
