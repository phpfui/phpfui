<?php

namespace PHPFUI\Input;

/**
 * Simple Time input wrapper that uses the mobile control if
 * possible
 */
class Time extends \PHPFUI\Input\Input
	{
	/**
	 * Constuct a Time input field supporting hours and minutes
	 *
	 * @param Page $page since we need to add JS
	 * @param string $name of the field
	 * @param string $label is optional
	 * @param ?string $value for initial display, can be military or
	 *                         AM/PM formated
	 * @param int $interval minute step interval, default 15.
	 */
	public function __construct(\PHPFUI\Page $page, string $name, string $label = '', ?string $value = '', int $interval = 15)
		{
		if ($page->isAndroid() || $page->isIOS())
			{
			// use a native picker for Android in hh:mm:ss format
			$value = self::toMilitary($value);
			parent::__construct('time', $name, $label, $value);
			// use a native picker for Android in hh:mm:ss format
			$this->addAttribute('pattern', 'military');
			$page->addPluginDefault('Abide', 'patterns["military"]', '/^(((([0-1][0-9])|(2[0-3])):?[0-5][0-9])|(24:?00))/');
			$this->addAttribute('step', $interval * 60);
			}
		elseif (! $page->hasTimePicker())
			{  // if we can't use a native, then use JS version

			parent::__construct('text', $name, $label, $value);
			$page->addJavaScript('$("#' . $this->getId() . '").AnyPicker({mode:"datetime",rowsNavigation:"scroller+buttons",selectedDate:"' . $value .
				'",dateTimeFormat:"h:mm AA",intervals:{h:1,m:' . $interval . '},viewSections:{header:["headerTitle"],contentTop:[],contentBottom:[],footer:["cancelButton","clearButton","setButton"]}});');
			$page->addStyleSheet('anypicker/anypicker-font.css');
			$page->addStyleSheet('anypicker/anypicker.min.css');
			$page->addTailScript('anypicker/anypicker.min.js');
			}
		else
			{
			parent::__construct('time', $name, $label, $value);
			$this->addAttribute('step', $interval * 60);
			}
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
		$hour = \sprintf('%02d', $hour);
		$minute = \sprintf('%02d', $minute);
		$second = \sprintf('%02d', $second);

		return "{$hour}:{$minute}:{$second}";
		}
	}
