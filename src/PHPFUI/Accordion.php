<?php

namespace PHPFUI;

/**
 * Simple Accordian wrapper
 */
class Accordion extends \PHPFUI\UnorderedList
	{
	public function __construct()
		{
		parent::__construct();
		$this->addClass('accordion');
		$this->addAttribute('data-accordion');
		}

	/**
	 * Add a tab to the accordion.  Returns the added tab as a
	 * ListItem
	 *
	 * @param string $tabText what the tab will show to the user
	 * @param string $content html shown when the tab is clicked
	 * @param bool $active set to true to expand on initial load,
	 *  			default false
	 *
	 * @return AccordionItem that was added
	 */
	public function addTab(string $tabText, string $content, bool $active = false) : AccordionItem
		{
		$listItem = $this->getTab($tabText, $active);
		$listItem->addContent($content);
		$this->addItem($listItem);

		return $listItem;
		}

	/**
	 * Get a tab with no added content.  You must add content to it
	 * then add it the the Accordion via addItem
	 *
	 * @param string $tabText what the tab will show to the user
	 * @param bool $active set to true to expand on initial load,
	 *                     default false
	 */
	public function getTab(string $tabText, bool $active = false) : AccordionItem
		{
		$listItem = new \PHPFUI\AccordionItem($tabText);

		if ($active)
			{
			$listItem->addClass('is-active');
			}

		return $listItem;
		}
	}
