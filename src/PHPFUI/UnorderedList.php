<?php

namespace PHPFUI;

/**
 * UnorderedList <ul>
 *
 * Passing a Page to the constructor will allow the list item to be dragged and dropped
 */
class UnorderedList extends HTMLList
	{
	private $sortable;

	/**
	 * Construct a UnorderedList
	 *
	 * @param Page $page if supplied, then the unordered list will
	 *             allow drag and drop
	 */
	public function __construct(Page $page = null)
		{
		parent::__construct('ul');
		$this->sortable = null !== $page;

		if ($this->sortable)
			{
			$page->addTailScript('/html5sortable/html5sortable.min.js');
			$page->addJavaScript("sortable('.sortable',{forcePlaceholderSize:true})");
			$this->addClass('sortable');
			}
		}

	/**
	 * Add a ListItem <li> to the UnorderedList <ul>
	 */
	public function addItem(ListItem $item) : UnorderedList
		{
		if ($this->sortable)
			{
			$item->addClass('sortableItem');
			}

		parent::addItem($item);

		return $this;
		}
	}
