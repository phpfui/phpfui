<?php

namespace PHPFUI;

class AccordionTabs extends Base
	{

	protected $tabs = [];
	private $contentSection;
	private $tabSection;

	/**
	 * Construct a Tab
	 *
	 * @param Page $page required for JS
	 */
	public function __construct(Page $page)
		{
		}

	/**
	 * Add a Tab
	 *
	 * @param string $tabText to display on the tab
	 * @param string $content html to be displayed when the tab is
	 *                         selected, can be any Base or plain html
	 * @param bool $active optional, default false
	 *
	 * @return Tabs
	 */
	public function addTab(string $tabText, string $content, bool $active = false)
		{
		$this->content[$tabText] = ['content' => $content,
																'active'  => $active];

		return $this;
		}

	public function getContent() : HTML5Element
		{
		$this->generate();

		return $this->content;
		}

	public function getTabs() : UnorderedList
		{
		$this->generate();

		return $this->tabSection;
		}

	protected function getBody() : string
		{
		return '';
		}

	protected function getEnd() : string
		{
		return '';
		}

	protected function getStart() : string
		{
		if ($this->generate())
			{
			$this->add($this->tabSection);
			$this->add($this->contentSection);
			}

		return '';
		}

	private function generate() : bool
		{
		if (! $this->tabSection)
			{
			$this->tabSection = new UnorderedList();
			$this->tabSection->addAttribute('data-tabs');
			$this->tabSection->addClass('tabs');
			$this->contentSection = new HTML5Element('div');
			$this->contentSection->addClass('tabs-content');
			$this->contentSection->addAttribute('data-tabs-content', $this->tabSection->getId());

			foreach ($this->content as $name => $content)
				{
				$div = new HTML5Element('div');
				$div->addClass('tabs-panel');
				$div->add($content['content']);
				$active = $content['active'] ? ' aria-selected="true"' : '';
				$item = new ListItem("<a href='#{$div->getId()}'{$active}>{$name}</a>");
				$item->addClass('tabs-title');

				if ($content['active'])
					{
					$div->addClass('is-active');
					$item->addClass('is-active');
					}
				$this->tabSection->addItem($item);
				$this->contentSection->add($div);
				}

			return true;
			}

		return false;
		}

	}
