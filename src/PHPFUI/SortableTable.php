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

	protected function getSortIndicator(string $column) : string
		{
		$indicator = '&blacklozenge;';
		$parameters = $this->parameters;
		$parameters[$this->columnParameter] = $column;
		$parameters[$this->sortParameter] = 'a';

		if ($column == $this->sortedColumn)
			{
			if ('d' == $this->sortedOrder)
				{
				$indicator = '&blacktriangledown;';
				}
			else
				{
				$indicator = '&blacktriangle;';
				$parameters[$this->sortParameter] = 'd';
				}
			}
		elseif (! isset($this->sortableColumns[$column]))
			{
			return '';
			}
		$link = $this->url . '?' . http_build_query($parameters);

		return "<span class='float-right'><a href='{$link}'>{$indicator}</a></span>";
		}

	}
