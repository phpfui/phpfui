<?php

namespace PHPFUI;

/**
 * A simple way to display static text in some kind of ordered
 * way
 */
class Display extends GridX
	{
	private $align = 'left';

	private $label;
	private $text;

	/**
	 * A Display has a label and text to display
	 *
	 * @param string $label shown to user
	 * @param string $text or value of the field
	 */
	public function __construct(string $label, string $text)
		{
		$this->label = $label;
		$this->text = $text;
		parent::__construct();
		}

	/**
	 * You can set the alignment
	 *
	 * @param string $align Foundation alignment class name
	 *
	 */
	public function setAlign(string $align) : Display
		{
		$this->align = $align;

		return $this;
		}

	protected function getBody() : string
		{
		$this->addClass($this->align);
		$class = $this->getClass();
		$this->label = $this->getToolTip($this->label);

		return "<div class='medium-3 small-4 columns'><label {$class}><strong>{$this->label}</strong></label></div><div {$class}>{$this->text}</div>";
		}

	}
