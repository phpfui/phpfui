<?php

namespace PHPFUI;

/**
 * Create a table that is orderable via drag and drop
 */
class OrderableTable extends Table
	{
	public function __construct(Page $page)
		{
		parent::__construct();
		$this->page = $page;
		$this->page->addTailScript('html5sortable.min.js');
		$this->sortableBodyClass = ' class="table-sortable"';
		$this->sortableTrClass = ' class="row-sortable"><td class="handle">&updownarrow;</td';
		}
	}
