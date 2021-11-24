<?php

namespace PHPFUI;

/**
 * Wrapper for tables. Arrays passed in must be indexed with
 * column names.
 * ```
 *  $table = new \PHPFUI\Table(); $table->setHeaders({'value' => 'Members Signed In', 'key' => 'In the Past X Days']);
 *  $table->addColumnAttribute('value', ['style' => 'text-align:center;']);
 *  foreach ($results as $key => $value)
 *  	{
 *    $signupTable->addRow(['key' => $key, 'value' => $value]);
 *  	}
 * ```
 */
class Table extends \PHPFUI\HTML5Element
	{
	protected bool $alwaysOutput = false;

	protected string $caption = '';

	protected array $colspans = [];

	protected array $columnAttributes = [];

	protected bool $displayHeaders = true;

	protected array $footers = [];

	protected array $headers = [];

	protected array $nextRowAttributes = [];

	protected ?\PHPFUI\Interfaces\Page $page = null;

	protected string $recordId = '';

	protected array $rowAttributes = [];

	protected array $rows = [];

	protected string $sortableBodyClass = '';

	protected string $sortableTrClass = '';

	protected bool $strict = false;

	protected array $widths = [];

	public function __construct()
		{
		parent::__construct('table');
		}

	/**
	 * Allow arrow keys to move up and down rows with edit controls in them.
	 */
	public function addArrowNavigation(\PHPFUI\Interfaces\Page $page) : Table
		{
		$page->addTailScript('jquery.arrow_nav.js');
		$this->addClass('arrow-nav');

		return $this;
		}

	/**
	 * Add an attribute to a column
	 *
	 * @param string $column name to add
	 * @param array $attributePairs to add. Example: ['style' =>
	 *    'text-align:center;']
	 */
	public function addColumnAttribute(string $column, array $attributePairs) : Table
		{
		if (! isset($this->columnAttributes[$column]))
			{
			$this->columnAttributes[$column] = [];
			}

		foreach ($attributePairs as $class => $value)
			{
			if (! isset($this->columnAttributes[$column][$class]))
				{
				$this->columnAttributes[$column][$class] = '';
				}

			$this->columnAttributes[$column][$class] .= ' ' . $value;
			}

		return $this;
		}

	/**
	 * Add one footer field
	 *
	 * @param string $field column name
	 * @param string $footer name displayed to user
	 */
	public function addFooter(string $field, string $footer) : Table
		{
		$this->footers[$field] = $footer;

		return $this;
		}

	/**
	 * Add one header field
	 *
	 * @param string $field column name
	 * @param string $header name displayed to user
	 */
	public function addHeader(string $field, string $header) : Table
		{
		$this->headers[$field] = $header;

		return $this;
		}

	/**
	 * You can add any attribute to the next row (tr) that you want.  This only applies to the next row to be output and is reset for the next row.
	 */
	public function addNextRowAttribute(string $attribute, string $value) : Table
		{
		$this->nextRowAttributes[$attribute][] = $value;

		return $this;
		}

	/**
	 * Add a row.  You can also pass column spans which are
	 * possitional and do not need keys corresponding index to the row.
	 *
	 * @param array $row array indexes must correspond to headers if
	 *                        used.
	 * @param array $colspans are optional, but positional and need not
	 *                            correspond to the $row indexes
	 */
	public function addRow(array $row, array $colspans = []) : Table
		{
		$this->rows[] = $row;
		$this->colspans[] = $colspans;
		$this->rowAttributes[] = $this->nextRowAttributes;
		$this->nextRowAttributes = [];

		return $this;
		}

	/**
	 * Number of rows in the table.
	 */
	public function count() : int
		{
		return \count($this->rows);
		}

	/**
	 * Turn off headers by passing false
	 */
	public function displayHeaders(bool $display = true) : Table
		{
		$this->displayHeaders = $display;

		return $this;
		}

	/**
	 * Return the index key used to give each row a unique id.
	 */
	public function getRecordId() : string
		{
		return $this->recordId;
		}

	/**
	 * By default, tables will not output if they have no rows
	 */
	public function setAlwaysOutput(bool $alwaysOutput = true) : Table
		{
		$this->alwaysOutput = $alwaysOutput;

		return $this;
		}

	/**
	 * Set the table caption
	 */
	public function setCaption(string $caption) : Table
		{
		$this->caption = $caption;

		return $this;
		}

	/**
	 * Set the footers for the table. Array indexes should
	 * correspond to the row indexs.
	 */
	public function setFooters(array $footers) : Table
		{
		$this->footers = $footers;

		return $this;
		}

	/**
	 * Set the headers
	 *
	 * @param array $headers where index corresponds to the indexes
	 *                        used for the rows to be added
	 */
	public function setHeaders(array $headers) : Table
		{
		$this->headers = [];

		foreach ($headers as $key => $header)
			{
			if (\is_string($key))
				{
				$this->headers[$key] = $header;
				}
			else
				{
				$this->headers[$header] = $header;
				}
			}

		return $this;
		}

	/**
	 * Specify the row index key that will be used to form a unique Id for the row.
	 *
	 * $key should be the index into the row array that uniquely identifies the row in the table.
	 */
	public function setRecordId(string $key) : Table
		{
		$this->recordId = $key;

		return $this;
		}

	/**
	 * Set all the rows for a table
	 */
	public function setRows(array $rows) : Table
		{
		$this->rows = $rows;

		return $this;
		}

	/**
	 * Display "Missing X" for each field in a row that does not
	 * have a index corresponding to a header.  Useful for
	 * debugging.
	 */
	public function setStrict(bool $strict = true) : Table
		{
		$this->strict = $strict;

		return $this;
		}

	/**
	 * Set widths for each column
	 *
	 * @param array $widths array containing the column widths. The
	 *              width should contain % (preferred) or px
	 *              (discouraged). The array is positional and does
	 *              not need the keys to correspond to the column
	 *              names.
	 */
	public function setWidths(array $widths) : Table
		{
		$this->widths = $widths;

		return $this;
		}

	protected function getBody() : string
		{
		$output = '';

		if (\count($this->rows) || $this->alwaysOutput)
			{
			if ($this->caption)
				{
				$output .= "<caption>{$this->caption}</caption>";
				}

			if ($this->displayHeaders)
				{
				$output .= $this->outputRow('th', $this->headers, 'thead', [], $this->widths, 'width');
				}

			$output .= "<tbody{$this->sortableBodyClass}>";
			\reset($this->colspans);
			\reset($this->rowAttributes);

			foreach ($this->rows as $row)
				{
				$output .= $this->outputRow('td', $row, '', \current($this->rowAttributes), \current($this->colspans));
				\next($this->colspans);
				\next($this->rowAttributes);
				}

			$output .= '</tbody>' . $this->outputRow('td', $this->footers, 'tfoot');
			}

		return $output;
		}

	protected function getEnd() : string
		{
		return parent::getEnd() . '</div>';
		}

	protected function getSortHeader(string $field, string $title) : string
		{
		return $title;
		}

	protected function getStart() : string
		{
		if ($this->page && $this->sortableBodyClass)
			{
			$spanCount = \count($this->headers);

			if (! $spanCount)
				{
				$spanCount = \count($this->rows[0] ?? []);
				}

			$placeholder = "<tr><td colspan='{$spanCount}'><span class='center'>" . \PHPFUI\Language::$dropRowHere . '</span></td></tr>';
			$this->page->addJavaScript('sortable(".table-sortable",{items:"tr.row-sortable",forcePlaceholderSize:true,placeholder:"' . $placeholder . '",handle:"td.handle"})');
			}

		return '<div style="overflow-x:auto;">' . parent::getStart();
		}

	protected function outputRow(string $td, array $row, string $type = '', array $rowAttributes = [], array $attribute = [], string $attributeName = 'colspan') : string
		{
		if (! \count($row))
			{
			return '';
			}

		$output = '';

		if ($type)
			{
			$output .= "<{$type}>";
			}

		$recordId = 0;
		$id = '';

		if (! empty($this->recordId) && isset($row[$this->recordId]))
			{
			$recordId = $row[$this->recordId];
			$id = " id='{$this->recordId}-{$recordId}'";
			}

		$rowAttributeString = '';

		foreach ($rowAttributes as $rowAttribute => $value)
			{
			$rowAttributeString .= " {$rowAttribute}='" . \implode(' ', $value) . "' ";
			}

		$output .= "<tr{$id}{$rowAttributeString}{$this->sortableTrClass}>";

		if (\count($this->headers))
			{
			\reset($attribute);
			$inSpan = 0;

			foreach (\array_keys($this->headers) as $field)
				{
				$tdclass = $td;

				if (isset($this->columnAttributes[$field]))
					{
					foreach ($this->columnAttributes[$field] as $key => $class)
						{
						$tdclass .= " {$key}='{$class}'";
						}
					}

				$final = '';

				if (isset($row[$field]))
					{
					$final = "{$row[$field]}";
					}
				elseif ($this->strict)
					{
					$final = "missing {$field}";
					}

				if ('th' == $td)
					{
					$final = $this->getSortHeader($field, $final);
					}

				$id = '';

				if ($recordId)
					{
					$id = " id='{$field}-{$recordId}'";
					}

				if ($span = \current($attribute))
					{
					$inSpan = $span;
					$output .= "<{$tdclass} {$attributeName}='{$span}'{$id}>{$final}</{$td}>";
					}
				else
					{
					--$inSpan;
					}

				if ($inSpan <= 0)
					{
					$output .= "<{$tdclass}{$id}>{$final}</{$td}>";
					}

				\next($attribute);
				}
			}
		else
			{
			foreach ($row as $value)
				{
				$output .= "<{$td}>{$value}</{$td}>";
				}
			}

		$output .= '</tr>';

		if ($type)
			{
			$output .= "</{$type}>";
			}

		return $output;
		}
	}
