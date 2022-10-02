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

	/** @var array<string, array<string>> */
	protected array $colspans = [];

	/** @var array<string, array<string, string>> */
	protected array $columnAttributes = [];

	protected bool $displayHeaders = true;

	/** @var array<string, string> */
	protected array $footers = [];

	/** @var array<string, string> */
	protected array $headers = [];

	/** @var array<string, array<string>> */
	protected array $nextRowAttributes = [];

	protected ?\PHPFUI\Interfaces\Page $page = null;

	protected string $recordId = '';

	/** @var array<array<string, array<string>>> */
	protected array $rowAttributes = [];

	/** @var array<array<string>> */
	protected array $rows = [];

	protected string $sortableBodyClass = '';

	protected string $sortableTrClass = '';

	protected bool $strict = false;

	/** @var array<string> */
	protected array $widths = [];

	public function __construct()
		{
		parent::__construct('table');
		}

	/**
	 * Allow arrow keys to move up and down rows with edit controls in them.
	 */
	public function addArrowNavigation(\PHPFUI\Interfaces\Page $page) : static
		{
		$page->addTailScript('jquery.arrow_nav.js');
		$this->addClass('arrow-nav');

		return $this;
		}

	/**
	 * Add an attribute to a column
	 *
	 * @param string $column name to add
	 * @param array<string, string> $attributePairs to add. Example: ['style' =>
	 *    'text-align:center;']
	 */
	public function addColumnAttribute(string $column, array $attributePairs) : static
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
	public function addFooter(string $field, string $footer) : static
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
	public function addHeader(string $field, string $header) : static
		{
		$this->headers[$field] = $header;

		return $this;
		}

	/**
	 * Delete header field. Deletes the column. Can be called at anytime after a header is set but before output.
	 *
	 * @param string $field column name
	 */
	public function deleteHeader(string $field) : static
		{
		unset($this->headers[$field]);

		return $this;
		}

	/**
	 * You can add any attribute to the next row (tr) that you want.  This only applies to the next row to be output and is reset for the next row.
	 */
	public function addNextRowAttribute(string $attribute, string $value) : static
		{
		$this->nextRowAttributes[$attribute][] = $value;

		return $this;
		}

	/**
	 * Add a row.  You can also pass column spans which are
	 * possitional and do not need keys corresponding index to the row.
	 *
	 * @param array<string, string> $row array indexes must correspond to headers if
	 *                        used.
	 * @param array<string, array<string>> $colspans are optional, but positional and need not
	 *                            correspond to the $row indexes
	 */
	public function addRow(array $row, array $colspans = []) : static
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
	public function displayHeaders(bool $display = true) : static
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
	public function setAlwaysOutput(bool $alwaysOutput = true) : static
		{
		$this->alwaysOutput = $alwaysOutput;

		return $this;
		}

	/**
	 * Set the table caption
	 */
	public function setCaption(string $caption) : static
		{
		$this->caption = $caption;

		return $this;
		}

	/**
	 * Set the footers for the table. Array indexes should
	 * correspond to the row indexs.
	 *
	 * @param array<string, string> $footers
	 */
	public function setFooters(array $footers) : static
		{
		$this->footers = $footers;

		return $this;
		}

	/**
	 * Set the headers
	 *
	 * @param array<string> $headers where index corresponds to the indexes
	 *                        used for the rows to be added
	 */
	public function setHeaders(array $headers) : static
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
	public function setRecordId(string $key) : static
		{
		$this->recordId = $key;

		return $this;
		}

	/**
	 * Set all the rows for a table
	 * @param array<array<string>> $rows
	 */
	public function setRows(array $rows) : static
		{
		$this->rows = $rows;

		return $this;
		}

	/**
	 * Display "Missing X" for each field in a row that does not
	 * have a index corresponding to a header.  Useful for
	 * debugging.
	 */
	public function setStrict(bool $strict = true) : static
		{
		$this->strict = $strict;

		return $this;
		}

	/**
	 * Set widths for each column
	 *
	 * @param array<string> $widths array containing the column widths. The
	 *              width should contain % (preferred) or px
	 *              (discouraged). The array is positional and does
	 *              not need the keys to correspond to the column
	 *              names.
	 */
	public function setWidths(array $widths) : static
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

	/**
	 * @param array<string, string> $row
	 * @param array<string, array<string>> $rowAttributes
	 * @param array<string> $attribute
	 */
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

		if (isset($row[$this->recordId]) && \is_scalar($row[$this->recordId]))
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
					$final = (string)$row[$field];
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
