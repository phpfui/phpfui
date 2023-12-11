<?php

namespace PHPFUI;

/**
 * Passing a Page to the constructor will allow the list item to be dragged and dropped
 */
class UnorderedList extends \PHPFUI\HTMLList
	{
	private bool $sortable;

	/**
	 * @param ?\PHPFUI\Interfaces\Page $page if supplied, then the unordered list will allow drag and drop
	 */
	public function __construct(?\PHPFUI\Interfaces\Page $page = null)
		{
		parent::__construct('ul');
		$this->sortable = null !== $page;

		if ($this->sortable)
			{
			$page->addTailScript('html5sortable.min.js');
			$page->addJavaScript("sortable('.sortable',{forcePlaceholderSize:true})");
			$this->addClass('sortable');
			}
		}

	public function addItem(\PHPFUI\ListItem | \PHPFUI\HTMLList $item) : static
		{
		if ($this->sortable)
			{
			$item->addClass('sortableItem');
			}

		parent::addItem($item);

		return $this;
		}
	}
