<?php

namespace PHPFUI;

class AccordionItem extends \PHPFUI\ListItem
	{
	/**
	 * Simple wrapper for a ListItem <li>
	 *
	 * @param string $tabText text for the Accordion Tab
	 */
	public function __construct(string $tabText = '')
		{
		parent::__construct();
		$this->addClass('accordion-item');
		$this->addAttribute('data-accordion-item');
		$this->add("<a href='#' class='accordion-title'>{$tabText}</a>");
		}

	/**
	 * Add content to the AccordionItem
	 */
	public function addContent(string $content) : static
		{
		$div = new \PHPFUI\HTML5Element('div');
		$div->addClass('accordion-content');
		$div->addAttribute('data-tab-content');
		$div->add($content);
		$this->add($div);

		return $this;
		}
	}
