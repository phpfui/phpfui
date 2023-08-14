<?php

namespace PHPFUI;

class Pagination extends \PHPFUI\HTML5Element
	{
	private bool $alwaysShow = false;

	private int $ff = 0;

	private string $next = 'Next';

	private string $onPage;

	private string $pageText;

	private string $previous = 'Previous';

	private bool $started = false;

	private \PHPFUI\UnorderedList $ul;

	private int $window = 3;

	/**
	 * Show a pagination nav. If there is only one page, the paginator will not be generated.
	 *
	 * @param int $page current page you are on, zero based
	 * @param int $of number of total pages, one based
	 * @param string $baseUrl for navigation. The string 'PAGE'
	 *                         will be replaced by the current page number
	 */
	public function __construct(private int $page, private int $of, private string $baseUrl)
		{
		parent::__construct('nav');
		$this->addAttribute('aria-label', 'Pagination');
		$this->ul = new \PHPFUI\UnorderedList();
		$this->ul->addClass('pagination');
		$this->next = \PHPFUI\Language::$next;
		$this->previous = \PHPFUI\Language::$previous;
		$this->pageText = \PHPFUI\Language::$page;
		$this->onPage = \PHPFUI\Language::$onPage;
		}

	/**
	 * By default, if there is only one page, they paginator will not be shown.  Set to true to get a one page paginator.
	 */
	public function alwaysShow(bool $alwaysShow = true) : static
		{
		$this->alwaysShow = $alwaysShow;

		return $this;
		}

	/**
	 * Center the paginator
	 */
	public function center() : static
		{
		$this->ul->addClass('text-center');

		return $this;
		}

	/**
	 * Set the fast forward number.  Defaults to no fast forward.
	 */
	public function setFastForward(int $ff = 0) : static
		{
		$this->ff = $ff;

		return $this;
		}

	/**
	 * Set the next pointer text
	 */
	public function setNext(string $next = 'Next') : static
		{
		$this->next = $next;

		return $this;
		}

	/**
	 * Set the previous pointer text
	 */
	public function setPrevious(string $previous = 'Previous') : static
		{
		$this->previous = $previous;

		return $this;
		}

	/**
	 * Set the window size. Number of items on each side of the
	 * current page
	 */
	public function setWindow(int $window) : static
		{
		$this->window = $window;

		return $this;
		}

	protected function getStart() : string
		{
		if (! $this->started)
			{
			$this->started = true;

			if ($this->of > 1 || $this->alwaysShow)
				{
				$item = new \PHPFUI\ListItem();
				$item->addClass('pagination-previous');
				$text = "{$this->previous} <span class='show-for-sr'>{$this->pageText}</span>";

				if ($this->page <= 0 || ! $this->of)
					{
					$item->add($text);
					$item->disabled();
					}
				else
					{
					$prevUrl = $this->getUrl($this->page - 1);
					$item->add("<a href='{$prevUrl}' aria-label='{$this->previous} {$this->pageText}'>{$text}</a>");
					}
				$this->ul->addItem($item);
				$this->ul->addItem($this->getPageItem(0));

				// four cases, all have first and last page shown already

				$startWindow = $this->window * 2;
				$endWindow = $this->of - $this->window - 1;

				// all pages shown
				if ($startWindow >= $endWindow)
					{
					for ($i = 1; $i < $this->of - 1; ++$i)
						{
						$this->ul->addItem($this->getPageItem($i));
						}
					} // 1-n ... x
				elseif ($this->page <= $startWindow)
					{
					for ($i = 1; $i < $startWindow + $this->window; ++$i)
						{
						$this->ul->addItem($this->getPageItem($i));
						}
					$this->ul->addItem($this->getEllipsisItem($this->ff));
					} // 1 ... range ... x
				elseif ($this->page > $startWindow && $this->page < $endWindow)
					{
					$this->ul->addItem($this->getEllipsisItem(0 - $this->ff));

					for ($i = $this->page - $this->window; $i <= $this->page + $this->window; ++$i)
						{
						$this->ul->addItem($this->getPageItem($i));
						}
					$this->ul->addItem($this->getEllipsisItem($this->ff));
					} // 1 ... n-x
				else
					{
					$this->ul->addItem($this->getEllipsisItem(0 - $this->ff));

					for ($i = $endWindow - $this->window; $i < $this->of - 1; ++$i)
						{
						$this->ul->addItem($this->getPageItem($i));
						}
					}

				if ($this->of > 1)
					{
					$this->ul->addItem($this->getPageItem($this->of - 1));
					}
				$item = new \PHPFUI\ListItem();
				$item->addClass('pagination-next');
				$text = "{$this->next} <span class='show-for-sr'>{$this->pageText}</span>";

				if (! $this->of || $this->page == $this->of - 1)
					{
					$item->add($text);
					$item->disabled();
					}
				else
					{
					$nextUrl = $this->getUrl($this->page + 1);
					$item->add("<a href='{$nextUrl}' aria-label='{$this->next} {$this->pageText}'>{$text}</a>");
					}
				$this->ul->addItem($item);
				}
			$this->add($this->ul);
			}

		return parent::getStart();
		}

	/**
	 * Return the url with the correct page included
	 */
	protected function getUrl(int $page) : string
		{
		return \str_replace('PAGE', (string)$page, $this->baseUrl);
		}

	private function getEllipsisItem(int $ff) : ListItem
		{
		$item = new \PHPFUI\ListItem();

		if ($ff && $this->page + $ff > 0 && $this->page + $ff < $this->of)
			{
			$page = \min(\max(0, $this->page + $ff), $this->of - 1);
			$sign = '';

			if ($ff < 0)
				{
				$item->addClass('pagination-previous');
				}
			else
				{
				$sign = '+';
				$item->addClass('pagination-next');
				}
			$url = $this->getUrl($page);
			$item->add("<a href='{$url}' aria-label='{$this->pageText} {$page}'>{$sign}{$ff}</a>");
			}
		else
			{
			$item->addClass('ellipsis');
			}
		$item->addAttribute('aria-hidden', 'true');
		$item->addAttribute('style', 'display:inline-block');

		return $item;
		}

	/**
	 * $page is zero based, so add one for display only
	 */
	private function getPageItem(int $page) : ListItem
		{
		$item = new \PHPFUI\ListItem();

		if ($page == $this->page)
			{
			++$page;
			$item->addClass('current');
			$item->add("<span class='show-for-sr'>{$this->onPage}</span> {$page}");
			}
		else
			{
			$url = $this->getUrl($page);
			++$page;
			$item->add("<a href='{$url}' aria-label='{$this->pageText} {$page}'>{$page}</a>");
			}

		return $item;
		}
	}
