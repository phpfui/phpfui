<?php

namespace PHPFUI\Input;

/**
 * Date input control.  Now uses build in browser support only.
 */
class Date extends \PHPFUI\Input\Input
	{
	/**
	 * Construct a Date input. Native controls are always used since there is now full browser support.
	 *
	 * @param \PHPFUI\Interfaces\Page $page for needed JS
	 * @deprecated $page parameter is no longer used. Will be removed in V7.
	 * @param string $name of field
	 * @param string $label optional
	 * @param ?string $value optional in YYYY-MM-DD format
	 */
	// @phpstan-ignore-next-line
	public function __construct(\PHPFUI\Interfaces\Page $page, string $name, string $label = '', ?string $value = '')
		{
		if ('0000-00-00' == $value)
			{
			$value = null;
			}
			parent::__construct('date', $name, $label, $value);
		}

	/**
	 * @deprecated no longer needed. Will be removed in V7.
	 */
	public function addOption(string $option, mixed $value) : static
		{
		return $this;
		}

	/**
	 * Set the maximum date the date picker will allow. Not well
	 * supported by all browsers.
	 *
	 * @param string $date in YYYY/MM/DD format
	 * @deprecated use addAttribute('max', ...) instead. Will be removed in V7.
	 */
	public function setMaxDate(string $date) : static
		{
		$this->addAttribute('max', $date);

		return $this;
		}

	/**
	 * Set the minumum date the date picker will allow. Not well
	 * supported by all browsers.
	 *
	 * @param string $date in YYYY/MM/DD format
	 * @deprecated use addAttribute('max', ...) instead. Will be removed in V7.
	 */
	public function setMinDate(string $date) : static
		{
		$this->addAttribute('min', $date);

		return $this;
		}
	}
