<?php

namespace PHPFUI\Input;

/**
 * Simple wrapper for OptGroup used by Select. Countable.
 */
class OptGroup extends HTML5Element implements \Countable
	{

	protected $options = [];

	/**
	 * Construct a OptGroup
	 *
	 * @param string $label of the OptGroup
	 */
	public function __construct(string $label)
		{
		parent::__construct('optgroup');
		$this->addAttribute('label', $label);
		}

	/**
	 * Add an option
	 *
	 * @param string $label for the option
	 * @param string $value for the Select. Returned when posted.
	 * @param bool $selected true if selected, default false
	 * @param bool $disabled default false
	 *
	 */
	public function addOption(string $label, string $value = '', bool $selected = false, bool $disabled = false) : OptGroup
		{
		if (null === $value || (is_string($value) && '' == $value))
			{
			$value = $label;
			}
		$this->options[] = ['label'    => \PHPFUI\TextHelper::htmlentities($label),
												'value'    => $value,
												'selected' => $selected ? 'selected' : '',
												'disabled' => $disabled ? 'disabled' : '',];

		return $this;
		}

	/**
	 * Return the number of options added
	 */
	public function count() : int
		{
		return count($this->options);
		}

	protected function getBody() : string
		{
		$output = '';

		foreach ($this->options as $option)
			{
			$selected = $option['selected'];
			$disabled = $option['disabled'];
			$output .= "<option value='{$option['value']}' {$selected} {$disabled}>{$option['label']}</option>";
			}

		return $output;
		}

	}
