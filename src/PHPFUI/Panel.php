<?php

namespace PHPFUI;

/**
 * Basic wrapper for Panels
 */
class Panel extends \PHPFUI\HTML5Element
	{
	protected string $text;

	/**
	 * @param string $text for the Panel
	 */
	public function __construct(string $text = '')
		{
		parent::__construct('div');
		$this->addClass('panel');
		$this->setText($text);
		}

	/**
	 * Make it a call out Panel
	 */
	public function setCallout() : static
		{
		$this->addClass('callout');

		return $this;
		}

	/**
	 * Make the Panel round
	 */
	public function setRadius() : static
		{
		$this->addClass('radius');

		return $this;
		}

	/**
	 * Set text if not set in the constructor
	 */
	public function setText(string $text) : static
		{
		$this->text = $text;

		return $this;
		}

	protected function getBody() : string
		{
		return $this->text;
		}
	}
