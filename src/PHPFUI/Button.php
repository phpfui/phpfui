<?php

namespace PHPFUI;

/**
 * Implements a button which can be used to open a reveal dialog
 * among other things.
 */
class Button extends \PHPFUI\HTML5Element
	{
	protected string $link = '';

	private bool $started = false;

	/**
	 * Make a button
	 *
	 * @param string $text of button
	 * @param string $link if needed
	 */
	public function __construct(protected string $text, string $link = '')
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
		$this->addClass('button');
		}

	/**
	 * returns the button link
	 */
	public function getLink() : string
		{
		return $this->link;
		}

	/**
	 * returns the button text
	 */
	public function getText() : string
		{
		return $this->text;
		}

	/**
	 * set the button link
	 */
	public function setLink(string $link) : static
		{
		$this->link = $link;

		return $this;
		}

	/**
	 * set the button text
	 */
	public function setText(string $text) : static
		{
		$this->text = $text;

		return $this;
		}

	/**
	 * Set the disabled state of the button
	 *
	 * @param bool $disabled defaults to true
	 */
	public function setDisabled(bool $disabled = true) : static
		{
		if ($disabled)
			{
			$this->addClass('disabled');
			}
		else
			{
			$this->deleteClass('disabled');
			}

		return $this;
		}

	protected function getStart() : string
		{
		if (! $this->started)
			{
			$this->started = true;
			$this->add($this->text);

			if ($this->link && ! $this->hasClass('disabled'))
				{
				$this->setAttribute('href', $this->link);
				}
			}

		return parent::getStart();
		}
	}
