<?php

namespace PHPFUI;

/**
 * The basic HTML5Element that handles common Foundation things and HTML closing tags
 *
 */
class HTML5Element extends Base
	{

	private $element;
	private $noEndTag = false;
	private static $noEndTags = [
		'area'    => true,
		'base'    => true,
		'br'      => true,
		'col'     => true,
		'command' => true,
		'embed'   => true,
		'hr'      => true,
		'img'     => true,
		'input'   => true,
		'keygen'  => true,
		'link'    => true,
		'meta'    => true,
		'param'   => true,
		'source'  => true,
		'track'   => true,
		'wbr'     => true,
	];
	private $tooltip;

	/**
	 * Construct an object with the tag name, ie. DIV, SPAN, TEXTAREA, etc
	 *
	 * @param string $element
	 */
	public function __construct($element)
		{
		parent::__construct();
		$this->element = $element;
		$this->noEndTag = isset(self::$noEndTags[strtolower($element)]);
		}

	public function disabled() : HTML5Element
		{
		$this->addClass('disabled');

		return $this;
		}

	/**
	 * Return the type of the element
	 *
	 * @return string
	 */
	public function getElement()
		{
		return $this->element;
		}

	/**
	 * Get the tool tip as a string
	 *
	 *
	 * @return ToolTip|string
	 */
	public function getToolTip(string $label)
		{
		$toolTip = $label;

		if ($this->tooltip)
			{
			if ('string' == gettype($this->tooltip))
				{
				$toolTip = new ToolTip($label, $this->tooltip);
				}
			else
				{
				$toolTip = $this->tooltip;
				$toolTip->add($label);
				}
			}

		return $toolTip;
		}

	/**
	 * A simple way to set a confirm on click
	 *
	 * @param string $text confirm text
	 *
	 */
	public function setConfirm($text) : HTML5Element
		{
		$this->addAttribute('onclick', "return window.confirm(\"{$text}\");");

		return $this;
		}

	/**
	 * You can set the element type if you need to morph it for some reason
	 *
	 * @param string $element
	 *
	 */
	public function setElement($element) : HTML5Element
		{
		$this->element = $element;
		$this->noEndTag = isset(self::$noEndTags[strtolower($element)]);

		return $this;
		}

	/**
	 * Set the tool tip.  Can either be a ToolTip or a string.  If it is a string, it will be converted to a ToolTip
	 *
	 * @param string|ToolTip $tip
	 *
	 */
	public function setToolTip($tip) : HTML5Element
		{
		if ($tip)
			{
			$type = gettype($tip);

			if ('string' == $type || ('object' == $type && get_class($tip) == __NAMESPACE__ . '\ToolTip'))
				{
				$this->tooltip = $tip;
				}
			else
				{
				$this->tooltip = 'not a string or ToolTip object';
				}
			}

		return $this;
		}

	public function toggleAnimate(HTML5Element $element, string $animation) : HTML5Element
		{
		$this->addAttribute('data-toggle', $element->getId());
		$this->addAttribute('aria-controls', $element->getId());
		$this->setAttribute('aria-expanded', 'true');
		$element->addAttribute('data-toggler');
		$element->addAttribute('data-animate', $animation);

		return $this;
		}

	public function toggleClass(HTML5Element $element, string $class) : HTML5Element
		{
		$this->addAttribute('data-toggle', $element->getId());
		$this->addAttribute('aria-controls', $element->getId());
		$this->setAttribute('aria-expanded', 'true');
		$element->addAttribute('data-toggler', $class);

		return $this;
		}

	protected function getBody() : string
		{
		return '';
		}

	protected function getEnd() : string
		{
		return (! $this->element || $this->noEndTag) ? '' : "</{$this->element}>";
		}

	protected function getStart() : string
		{
		// We might not be a real HTML Element!
		if (! $this->element)
			{
			return '';
			}
		$output = "<{$this->element} ";
		$output .= $this->getIdAttribute();
		$output .= $this->getClass();
		$output .= $this->getAttributes();

		if ($this->noEndTag)
			{
			$output .= '/';
			}

		return $output . '>';
		}

	}
