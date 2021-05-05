<?php

namespace PHPFUI\Input;

/**
 * Date input control with support for native mobile input and a
 * custom datepicker for desktops.
 *
 * @link http://foundation-datepicker.peterbeno.com
 */
class Date extends \PHPFUI\Input\Input
	{
	use \PHPFUI\Traits\Page;

	protected $options = ['closeButton' => true];

	protected $page;

	/**
	 * Construct a Date input. Native mobile date controls used
	 * where possible. Custom date picker based off Bootstrap for
	 * desktops.
	 *
	 * @param Page $page for needed JS
	 * @param string $name of field
	 * @param string $label optional
	 * @param ?string $value optional in YYYY-MM-DD format
	 */
	public function __construct(\PHPFUI\Interfaces\Page $page, string $name, string $label = '', ?string $value = '')
		{
		$this->page = $page;

		if ($page->isChrome())
			{
			parent::__construct('date', $name, $label, $value);
			$page->addCSS(
				<<<CHROME_CSS
input[type="date"] {position: relative;}
/* make the native arrow invisible and stretch it over the whole field so you can click anywhere in the input field to trigger the native datepicker*/
input[type="date"]::-webkit-calendar-picker-indicator {position:absolute;top:0;left:0;right:0;bottom:0;width:auto;height:auto;color:transparent;background:transparent;}
/* adjust increase/decrease button */
input[type="date"]::-webkit-inner-spin-button {z-index: 1;}
/* adjust clear button */
input[type="date"]::-webkit-clear-button {z-index: 1;}
CHROME_CSS
			);
			}
		elseif (! $page->hasDatePicker())
			{  // if we can't use a native, then use JS version

			parent::__construct('text', $name, $label, $value);
			$page->addTailScript('datepicker/js/foundation-datepicker.min.js');
			$page->addStyleSheet('datepicker/css/foundation-datepicker.min.css');
			$this->addAttribute('data-date-format', 'yyyy-mm-dd');
			$this->addOption('format', '"yyyy-mm-dd"');
			$this->addAttribute('size', '10');
			}
		else
			{
			parent::__construct('date', $name, $label, $value);
			}
		}

	/**
	 * Add an option for the Foundation Date picker
	 *
	 * @link http://foundation-datepicker.peterbeno.com
	 * @param string $option name
	 */
	public function addOption(string $option, string $value) : Date
		{
		$this->options[$option] = $value;

		return $this;
		}

	/**
	 * Set the maximum date the date picker will allow. Not well
	 * supported by all browsers.
	 *
	 * @param string $date in YYYY/MM/DD format
	 */
	public function setMaxDate(string $date) : Date
		{
		$this->addAttribute('max', $date);
		$this->addOption('endDate', "'{$date}'");

		return $this;
		}

	/**
	 * Set the minumum date the date picker will allow. Not well
	 * supported by all browsers.
	 *
	 * @param string $date in YYYY/MM/DD format
	 */
	public function setMinDate(string $date) : Date
		{
		$this->addAttribute('min', $date);
		$this->addOption('startDate', "'{$date}'");

		return $this;
		}

	protected function getStart() : string
		{
		if (! $this->page->hasDatePicker())
			{  // if we can't use a native, then use JS version

			$id = $this->getId();
			$dollar = '$';
			$this->page->addJavaScript("{$dollar}('#{$id}').fdatepicker(" . \PHPFUI\TextHelper::arrayToJS($this->options) . ');');
			}

		return parent::getStart();
		}
	}
