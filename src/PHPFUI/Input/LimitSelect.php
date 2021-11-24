<?php

namespace PHPFUI\Input;

/**
 * LimitSelect is a Select box with the number of records to
 * show per page.
 *
 * It automatically generates and sets window.location to the
 * new URL refetching the page with the correct parameters.  It
 * keeps the top record in the new view to not completely
 * disorient the user.
 *
 * You can override the p (page) and l (limit) query string
 * parameters.
 *
 * Default limits are 10, 25, 50 and 100
 */
class LimitSelect extends \PHPFUI\Input\Select
	{
	use \PHPFUI\Traits\Page;

	private int $currentLimit;

	private string $limitName;

	private array $limits;

	private \PHPFUI\Interfaces\Page $page;

	private string $pageName;

	public function __construct(\PHPFUI\Interfaces\Page $page, int $currentLimit)
		{
		parent::__construct('l');
		$this->page = $page;
		$this->currentLimit = $currentLimit;
		$this->setLimits();
		$this->setLimitName();
		$this->setPageName();
		$this->addAttribute('onchange', "LimitSelect{$this->getId()}(this.value)");
		$this->page->addJavaScript('function computePage(newLimit,oldLimit,page){return Math.floor(page*oldLimit/newLimit)}');
		}

	public function getStart() : string
		{
		$parameters = $this->page->getQueryParameters();
		$this->removeAll();

		foreach ($this->limits as $limit)
			{
			$this->addOption($limit, $limit, $limit == $this->currentLimit);
			}

		$page = (int)($parameters[$this->pageName] ?? 1);
		unset($parameters[$this->pageName], $parameters[$this->limitName]);


		$query = \http_build_query($parameters);

		$js = "function LimitSelect{$this->getId()}(newLimit){" .
			"var p=new URLSearchParams('{$query}');" .
			"p.set('{$this->limitName}',newLimit);" .
			"p.set('{$this->pageName}',computePage(newLimit,{$this->currentLimit},{$page}));" .
			"window.location='{$this->page->getBaseURL()}?'+p.toString()}";
		$this->page->addJavaScript($js);

		return parent::getStart();
		}

	/**
	 * Set the parameter name for the limit.  Default is l.
	 */
	public function setLimitName(string $limitName = 'l') : LimitSelect
		{
		$this->limitName = $limitName;

		return $this;
		}

	/**
	 * Specify the limits to use
	 */
	public function setLimits(array $limits = [10, 25, 50, 100]) : LimitSelect
		{
		$this->limits = $limits;

		return $this;
		}

	/**
	 * Set the parameter name for the page.  Default is p.
	 */
	public function setPageName(string $pageName = 'p') : LimitSelect
		{
		$this->pageName = $pageName;

		return $this;
		}
	}
