<?php

namespace PHPFUI;

/**
 * A quick debug message for PDO compatible SQL statements. New lines before each major slq clause. Produces executable sql by substuting parameters for ? and :var
 */
class DebugSQL extends \PHPFUI\Debug
	{
	/**
	 * @param string $sql you want to output. ? and :var parameters are replaced if $input is provided
	 * @param array $inputs used to replace ? and :var
	 */
	public function __construct(string $sql, array $inputs = [])
		{
		$sql = "\n" . $sql;
		$clauses = ['JOIN', 'WHERE', 'ORDER', 'SORT', 'HAVING', 'GROUP', 'LIMIT'];

		foreach ($clauses as $clause)
			{
			$sql = \str_ireplace($clause, "\n" . $clause, $sql);
			}

		foreach ($inputs as $index => $input)
			{
			if (\is_string($input))
				{
				$input = '"' . $input . '"';
				}
			$position = \strpos($sql, '?');

			if (false !== $position)
				{
				$sql = \substr_replace($sql, (string)$input, $position, 1);
				}
			else
				{
				$sql = \str_replace(':' . $index, $input, $sql);
				}
			}

		parent::__construct($sql);
		}
	}
