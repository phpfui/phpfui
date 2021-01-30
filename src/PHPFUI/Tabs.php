<?php

namespace PHPFUI;

class Tabs extends \PHPFUI\Base
	{
	private $contentSection;

	private $tabs = [];

	private $tabSection;

	private $vertical = false;

	/**
	 * @param bool $vertical default false, pass true for a vertical tab structure
	 */
	public function __construct(bool $vertical = false)
		{
		$this->vertical = $vertical;
		}

	/**
	 * @param string $tabText to display on the tab
	 * @param string $content html to be displayed when the tab is
	 *                         selected, can be any Base or plain html
	 * @param bool $active optional, default false
	 */
	public function addTab(string $tabText, string $content, bool $active = false) : Tabs
		{
		$this->tabs[$tabText] = ['content' => $content,
			'active' => $active, ];

		return $this;
		}

	public function count() : int
		{
		return \count($this->tabs);
		}

	/**
	 * Return the content section for the Tabs.  You can call this
	 * separately and not add the Tabs object to the page if you
	 * need more control of where the content is located in the
	 * page. If you add the Tabs object to the page, it will add the
	 * tabs section, then the content section immediately after,
	 * which you might not want. If you call this separately, you
	 * are resposible for adding both the Tabs and content sections
	 * to the page.
	 */
	public function getContent() : HTML5Element
		{
		$this->generate();

		return $this->contentSection;
		}

	/**
	 * Return the Tabs section.  You can call this separately and
	 * not add the Tabs object to the page if you need more control
	 * of where the tabs are located in the page. If you add the
	 * Tabs object to the page, it will add the tabs section, then
	 * the content section immediately after, which you might not
	 * want.
	 */
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
			$this->tabSection->addAttribute('role', 'tablist');

			if ($this->vertical)
				{
				$this->tabSection->addClass('vertical');
				}

			$this->tabSection->addClass('tabs');
			$this->contentSection = new HTML5Element('div');
			$this->contentSection->addClass('tabs-content');
			$this->contentSection->addAttribute('data-tabs-content', $this->tabSection->getId());

			foreach ($this->tabs as $name => $content)
				{
				$div = new HTML5Element('div');
				$div->addClass('tabs-panel');
				$div->add($content['content']);
				$active = $content['active'] ? ' aria-selected="true"' : '';
				$item = new ListItem("<a href='#{$div->getId()}'{$active} role='tab'>{$name}</a>");
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
