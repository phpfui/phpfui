<?php

namespace PHPFUI\Input;

/**
 * Simple wrapper for OptGroup used by Select. Countable.
 */
class OptGroup extends \PHPFUI\HTML5Element implements \Countable
	{
	/** @var array<array<string, string | null>> */
	protected array $options = [];

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
	 * @param ?string $value for the Select. Returned when posted.
	 * @param bool $selected true if selected, default false
	 * @param bool $disabled default false
	 */
	public function addOption(string $label, ?string $value = null, bool $selected = false, bool $disabled = false) : static
		{
		$label = '' === $label ? '&nbsp;' : \PHPFUI\TextHelper::htmlentities($label);
		$this->options[] = ['label' => $label,
			'value' => $value,
			'selected' => $selected ? ' selected' : '',
			'disabled' => $disabled ? ' disabled' : '', ];

		return $this;
		}

	/**
	 * Return the number of options added
	 */
	public function count() : int
		{
		return \count($this->options);
		}

	protected function getBody() : string
		{
		$output = '';

		foreach ($this->options as $option)
			{
			$selected = $option['selected'];
			$disabled = $option['disabled'];
			$value = null !== $option['value'] ? " value='{$option['value']}'" : '';
			$output .= "<option{$value}{$selected}{$disabled}>{$option['label']}</option>";
			}

		return $output;
		}
	}
