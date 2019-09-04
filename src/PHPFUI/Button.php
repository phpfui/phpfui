<?php

namespace PHPFUI;

/**
 * Implements a button which can be used to open a reveal dialog
 * among other things.
 */
class Button extends HTML5Element
	{

	protected $link;
	protected $text;
	private $started = false;

	/**
	 * Make a button
	 *
	 * @param string $text of button
	 * @param string $link if needed
	 */
	public function __construct(string $text, string $link = '')
		{
		if ($link)
			{
			parent::__construct('a');
			}
		else
			{
			parent::__construct('button');
			$this->addAttribute('type', 'button');
			}
		$this->link = $link;
		$this->text = $text;
		$this->addClass('button');
		}

	/**
	 * returns the button text
	 *
	 * @return string
	 */
	public function getText()
		{
		return $this->text;
		}

	/**
	 * Set the disabled state of the button
	 *
	 * @param bool $disabled defaults to true
	 *
	 */
	public function setDisabled($disabled = true) : void
		{
		if ($disabled)
			{
			$this->addClass('disabled');
			}
		else
			{
			$this->deleteClass('disabled');
			}
		}

	protected function getStart() : string
		{
		if (! $this->started)
			{
			$this->started = true;
			$this->add($this->text);

			if ($this->link && ! $this->hasClass('disabled'))
				{
				$this->addAttribute('href', $this->link);
				}
			}

		return parent::getStart();
		}

	}
