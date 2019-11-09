<?php

namespace PHPFUI;

/**
 * Create a table that is sortedable
 */
class SortableTable extends Table
	{
	private $columnParameter = 'c';
	private $parameters = [];

	private $sortableColumns = [];
	private $sortedColumn = '';
	private $sortedOrder = '';
	private $sortParameter = 's';
	private $url;

	public function __construct()
		{
		parent::__construct();

		$this->url = $url = $_SERVER['REQUEST_URI'] ?? '';
		$queryStart = strpos($this->url, '?');

		if ($queryStart)
			{
			$this->url = substr($url, 0, $queryStart);
			parse_str(substr($url, $queryStart + 1), $this->parameters);
			}
		}

	public function getBaseUrl() : string
		{
		return $this->url;
		}

	public function getParsedParameters() : array
		{
		return $this->parameters;
		}

	public function setParameters(string $column = 'c', string $sort = 's') : SortableTable
		{
		$this->columnParameter = $column;
		$this->sortParameter = $sort;

		return $this;
		}

	public function setSortableColumns(array $columns) : SortableTable
		{
		$this->sortableColumns = array_flip($columns);

		return $this;
		}

	public function setSortedColumnOrder(string $column, string $order) : SortableTable
		{
		$order = strtolower($order);

		if (! in_array($order, ['a', 'd']))
			{
			$order = 'a';
			}

		$this->sortedOrder = $order;
		$this->sortedColumn = $column;

		return $this;
		}

	/**
	 * @return string a link that will sort the column in ascending order
	 */
	public function getUpUrl(string $column) : string
		{
		$parameters = $this->parameters;
		$parameters[$this->columnParameter] = $column;
		$parameters[$this->sortParameter] = 'a';

		return $this->url . '?' . http_build_query($parameters);
		}

	/**
	 * @return string a link that will sort the column in descending order
	 */
	public function getDownUrl(string $column) : string
		{
		$parameters = $this->parameters;
		$parameters[$this->columnParameter] = $column;
		$parameters[$this->sortParameter] = 'd';

		return $this->url . '?' . http_build_query($parameters);
		}

	protected function getSortIndicator(string $column) : string
		{
		if (! isset($this->sortableColumns[$column]))
			{
			return '';
			}

		$downUrl = $this->getDownUrl($column);
		$down = '&Or;';
		$upUrl = $this->getUpUrl($column);
		$up = '&And;';
		$indicator = "<a href='{$upUrl}'>{$up}</a><a href='{$downUrl}'>{$down}</a>";

		if ($column == $this->sortedColumn)
			{
			if ('d' == $this->sortedOrder)
				{
				$indicator = "<a href='{$upUrl}'>{$down}</a>";
				}
			else
				{
				$indicator = "<a href='{$downUrl}'>{$up}</a>";
				}
			}

		return "<span class='float-right'>{$indicator}</span>";
		}
	}
