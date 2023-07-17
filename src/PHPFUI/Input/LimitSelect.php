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

	private string $limitName;

	/** @var array<int> */
	private array $limits;

	private string $pageName;

	public function __construct(protected \PHPFUI\Interfaces\Page $page, private int $currentLimit)
		{
		parent::__construct('l');
		$this->addPHPClassName();
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

		if (! \in_array($this->currentLimit, $this->limits))
			{
			$this->limits[] = $this->currentLimit;
			\sort($this->limits);
			}

		foreach ($this->limits as $limit)
			{
			$this->addOption((string)$limit, (string)$limit, $limit == $this->currentLimit);
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
	public function setLimitName(string $limitName = 'l') : static
		{
		$this->limitName = $limitName;

		return $this;
		}

	/**
	 * Specify the limits to use
	 *
	 * @param array<int> $limits
	 */
	public function setLimits(array $limits = [10, 25, 50, 100]) : static
		{
		$this->limits = $limits;

		return $this;
		}

	/**
	 * Set the parameter name for the page.  Default is p.
	 */
	public function setPageName(string $pageName = 'p') : static
		{
		$this->pageName = $pageName;

		return $this;
		}
	}
