<?php

namespace PHPFUI;

/**
 * Basic wrapper for Panels
 */
class Panel extends \PHPFUI\HTML5Element
	{
	protected $text;

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
	public function setCallout() : Panel
		{
		$this->addClass('callout');

		return $this;
		}

	/**
	 * Make the Panel round
	 */
	public function setRadius() : Panel
		{
		$this->addClass('radius');

		return $this;
		}

	/**
	 * Set text if not set in the constructor
	 */
	public function setText($text) : Panel
		{
		$this->text = $text;

		return $this;
		}

	protected function getBody() : string
		{
		return $this->text;
		}
	}
