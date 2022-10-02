<?php

namespace PHPFUI;

/**
 * Radio Buttons for inserting a table
 */
class RadioTable extends \PHPFUI\Input implements \Countable
	{
	/** @var array<string, \PHPFUI\RadioTableCell> */
	protected array $buttons = [];

	/**
	 * @param string $name of the button
	 * @param ?string $value initial value
	 */
	public function __construct(\PHPFUI\Interfaces\Page $page, string $name, ?string $value = null)
		{
		parent::__construct('text', $name, $value);

		$page->addJavaScript('function checkRadioTable(id,foregroundColor,backgroundColor){var cb=$("#"+id);' .
		'cb.parent().prop("style","background-color:"+backgroundColor+";color:"+foregroundColor+";");};');
		}

	/**
	 * Add a optional button
	 */
	public function addButton(\PHPFUI\RadioTableCell $button) : static
		{
		$button->setParent($this);
		$this->buttons[$button->getName()] = $button;

		return $this;
		}

	public function addClassesToTable(\PHPFUI\Table $table) : static
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
	 *
	 * @return array<string, \PHPFUI\RadioTableCell>
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
