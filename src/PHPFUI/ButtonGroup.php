<?php

namespace PHPFUI;

/**
 * Implements a ButtonGroup and Countable
 */
class ButtonGroup extends \PHPFUI\HTML5Element implements \Countable
	{
	protected array $buttons = [];

	private bool $started = false;

	public function __construct()
		{
		parent::__construct('div');
		$this->addClass('button-group');
		}

	/**
	 * Add a button to the group with optional class
	 *
	 * @param Button $button to add
	 */
	public function addButton(Button $button) : ButtonGroup
		{
		$this->buttons[] = $button;

		return $this;
		}

	/**
	 * Add a class to all buttons in group
	 *
	 * @param string $class to add
	 */
	public function addButtonClass($class) : ButtonGroup
		{
		foreach ($this->buttons as &$button)
			{
			$button->addClass($class);
			}

		return $this;
		}

	/**
	 * Returns the number of buttons in the group
	 */
	public function count() : int
		{
		return \count($this->buttons);
		}

	/**
	 * Set a specific button in the bar to a new button, or add it
	 * if index is past the end of the group.
	 *
	 * @param int $index of the button to replace
	 * @param Button $button to replace
	 */
	public function setButton($index, Button $button) : ButtonGroup
		{
		if ($index >= 0 && $index < \count($this->buttons))
			{
			$this->buttons[$index] = $button;
			}
		else
			{
			$this->buttons[] = $button;
			}

		return $this;
		}

	protected function getStart() : string
		{
		if (! $this->started)
			{
			$this->started = true;

			foreach ($this->buttons as $button)
				{
				$this->add($button);
				}
			}

		return parent::getStart();
		}
	}
