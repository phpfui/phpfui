<?php

namespace PHPFUI\Input;

/**
 * Simple Time input wrapper that uses the mobile control if
 * possible
 */
class Time extends \PHPFUI\Input\Input
	{
	private static ?\PHPFUI\Interfaces\Page $page = null;

	/**
	 * Constuct a Time input field supporting hours and minutes
	 *
	 * @param \PHPFUI\Page $page since we need to add JS
	 * @param string $name of the field
	 * @param string $label is optional
	 * @param ?string $value for initial display, can be military or
	 *                         AM/PM formated
	 * @param int $interval minute step interval, default 15.
	 */
	public function __construct(\PHPFUI\Page $page, string $name, string $label = '', ?string $value = '', int $interval = 15)
		{
		$value = self::toMilitary($value);

		if ($page->isAndroid() || $page->isIOS())
			{
			// use a native picker for Android in hh:mm:ss format
			parent::__construct('time', $name, $label, $value);
			// use a native picker for Android in hh:mm:ss format
			$this->addAttribute('pattern', 'military');
			$page->addPluginDefault('Abide', 'patterns["military"]', '/^(((([0-1][0-9])|(2[0-3])):?[0-5][0-9])|(24:?00))/');
			}
		elseif (! $page->hasTimePicker())
			{  // if we can't use a native, then use JS version
			parent::__construct('time', $name, $label, $value);
			$js = "var tp=TimePicker('blue');";
			$page->addJavaScript($js);
			$onclickJs = 'let input=$(this);tp.show(input,{callback:function(selected){let timeString=selected instanceof Date?selected.toTimeString().substring(0,8):"";input.attr("value",timeString)}})';
			$this->addAttribute('onfocus', $onclickJs);
			$page->addStyleSheet('css/timepicker.css');
			$page->addTailScript('timepicker.js');

			if (! self::$page)
				{
				$page->add($this->getTemplate());
				}
			self::$page = $page;
			}
		else
			{
			parent::__construct('time', $name, $label, $value);
			}
		$this->addAttribute('step', $interval * 60);
		}

	/**
	 * Convert a time string to military format, which is the stand format for times in HTML
	 */
	public static function toMilitary(string $timeString) : string
		{
		$timeString = \str_replace('P', ' P', \strtoupper($timeString));
		$timeString = \str_replace('A', ' A', $timeString);
		$timeString = \str_replace(':', ' ', $timeString);
		$timeString = \str_replace('  ', ' ', $timeString);
		$array = \explode(' ', $timeString);
		$positions = \count($array);
		$ampm = 'AM';
		$hour = $minute = $second = 0;

		if (\strpos($timeString, 'A') || \strpos($timeString, 'P'))
			{
			switch ($positions)
				{
				case 4:
					[$hour, $minute, $second, $ampm] = $array;

					break;

				case 3:
					[$hour, $minute, $ampm] = $array;

					break;

				case 2:
					[$hour, $ampm] = $array;

					break;

				case 1:
					$hour = (int)$timeString;

					break;
				}

			if (false !== \strpos($ampm, 'P'))
				{
				$hour += 12;
				}
			}
		else
			{
			switch ($positions)
				{
				case 3:
					[$hour, $minute, $second] = $array;

					break;

				case 2:
					[$hour, $minute] = $array;

					break;

				case 1:
					$hour = (int)$timeString;

					break;
				}
			}

		if ($hour > 23 || $hour < 0 || $minute < 0 || $minute > 59)
			{
			return '';
			}

		return \sprintf('%02d:%02d:%02d', $hour, $minute, $second);
		}

	private function getTemplate() : string
		{
		$menu = new \PHPFUI\Menu();
		$menu->addClass('align-center');
		$menu->setId('timepicker-buttons');
		$now = new \PHPFUI\MenuItem('NOW', '#');
		$now->setId('timepicker-now-button');
		$menu->addMenuItem($now);

		$clear = new \PHPFUI\MenuItem('CLEAR', '#');
		$clear->setId('timepicker-clear-button');
		$menu->addMenuItem($clear);

		$cancel = new \PHPFUI\MenuItem('CANCEL', '#');
		$cancel->setId('timepicker-cancel-button');
		$menu->addMenuItem($cancel);

		$set = new \PHPFUI\MenuItem('SET', '#');
		$set->setId('timepicker-set-button');
		$menu->addMenuItem($set);

		return "<div id='timepicker' class='reveal small' data-reveal>
<div id='timepicker-header' class='timepicker-bg'>
<div>
<span id='timepicker-hour'></span>
<span id='timepicker-mins'></span>
<span id='timepicker-ampm'></span>
</div>
</div>
<div id='timepicker-am-button' class='timepicker-ampm-button float-left'>AM</div>
<div id='timepicker-pm-button' class='timepicker-ampm-button float-right'>PM</div>
<div id='timepicker-flex'>
<div id='timepicker-clock'>
<span id='timepicker-hour-hand'></span>
<span id='timepicker-hour-center'></span>
<div id='timepicker-hour-1' class='timepicker-hour' data-value='1'></div>
<div id='timepicker-hour-2' class='timepicker-hour' data-value='2'></div>
<div id='timepicker-hour-3' class='timepicker-hour' data-value='3'></div>
<div id='timepicker-hour-4' class='timepicker-hour' data-value='4'></div>
<div id='timepicker-hour-5' class='timepicker-hour' data-value='5'></div>
<div id='timepicker-hour-6' class='timepicker-hour' data-value='6'></div>
<div id='timepicker-hour-7' class='timepicker-hour' data-value='7'></div>
<div id='timepicker-hour-8' class='timepicker-hour' data-value='8'></div>
<div id='timepicker-hour-9' class='timepicker-hour' data-value='9'></div>
<div id='timepicker-hour-10' class='timepicker-hour' data-value='10'></div>
<div id='timepicker-hour-11' class='timepicker-hour' data-value='11'></div>
<div id='timepicker-hour-12' class='timepicker-hour' data-value='12'></div>
</div>
</div>
{$menu}
</div>";
		}
	}
