<?php

namespace PHPFUI;

/**
 * Radio Buttons for inserting a table
 */
class RadioTable extends \PHPFUI\Input implements \Countable
	{
	protected $buttons = [];

	/**
	 * @param string $name of the button
	 * @param ?string $value initial value
	 */
	public function __construct(\PHPFUI\Interfaces\Page $page, string $name, ?string $value = null)
		{
		parent::__construct('text', $name, null, $value);

		$page->addJavaScript('function checkRadioTable(id,foregroundColor,backgroundColor){var cb=$("#"+id);' .
		'cb.parent().prop("style","background-color:"+backgroundColor+";color:"+foregroundColor+";");};');
		}

	/**
	 * Add a optional button
	 */
	public function addButton(RadioTableCell $button) : RadioTable
		{
		$button->setParent($this);
		$this->buttons[$button->getName()] = $button;

		return $this;
		}

	public function addClassesToTable(Table $table) : RadioTableCell
		{
		foreach (\array_keys($this->buttons) as $name)
			{
			$table->addColumnAttribute($name, ['class' => 'RadioTableCell']);
			}

		return $this;
		}

	/**
	 * Return number of buttons so far
	 */
	public function count() : int
		{
		return \count($this->buttons);
		}

	/**
	 * Get buttons, indexed by name
	 */
	public function getButtons() : array
		{
		return $this->buttons;
		}

	protected function getBody() : string
		{
		return '';
		}

	protected function getEnd() : string
		{
		return '';
		}

	protected function getStart() : string
		{
		return '';
		}
	}
