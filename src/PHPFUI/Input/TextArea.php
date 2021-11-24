<?php

namespace PHPFUI\Input;

/**
 * A text area wrapper with support for WYSIWYG html editing
 */
class TextArea extends \PHPFUI\Input\Input
	{
	private int $rows = 10;

	/**
	 * Construct a TextArea
	 *
	 * @param string $name of field
	 * @param string $label optional
	 * @param ?string $value inital value
	 */
	public function __construct(string $name, string $label = '', ?string $value = '')
		{
		parent::__construct('text', $name);
		$this->value = $value;
		$this->label = $label;
		}

	/**
	 * enable html editing using a JavaScript Editor
	 *
	 * @param Page $page requires JS
	 */
	public function htmlEditing(\PHPFUI\Interfaces\Page $page, \PHPFUI\Interfaces\HTMLEditor $model) : TextArea
		{
		$id = $this->getId();
		$model->updatePage($page, $id);

		return $this;
		}

	/**
	 * Set the number of rows the text area occupies
	 *
	 * @param int $rows default 10
	 */
	public function setRows(int $rows = 10) : TextArea
		{
		$this->rows = $rows;

		return $this;
		}

	protected function getEnd() : string
		{
		$output = '</textarea>';

		if (! empty($this->error))
			{
			$output .= "<small class='error'>{$this->error}</small>";
			}

		return $output;
		}

	protected function getStart() : string
		{
		$this->addAttribute('rows', $this->rows);
		$label = new \PHPFUI\HTML5Element('label');
		$label->add($this->getToolTip($this->getLabel()));

		if ($this->required)
			{
			$label->add(\PHPFUI\Language::$required);
			}
		$label->addAttribute('for', $this->getId());

		$output = $label . '<textarea';
		$output .= $this->getIdAttribute();
		$output .= " name='{$this->name}'";
		$this->deleteAttribute('onkeypress');
		$output .= $this->getAttributes();
		$output .= '>';
		$output .= $this->value;

		return $output;
		}
	}
