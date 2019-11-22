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
	private $attributes = [];
	private $classes = [];
	private $id = null;
	private static $masterId = 0;

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

	public function __clone()
		{
		if ($this->hasId())
			{
			$this->newId();
			}
		parent::__clone();
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
	 * @return bool if there is a tool tip associated with this element
	 */
	public function hasToolTip()
		{
		return $this->tooltip !== null;
		}

	/**
	 * Get the tool tip as a string
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

	/**
	 * Add an attribute the the object
	 *
	 * @param string $value of the attribute, blank for just a plain attribute
	 *
	 */
	public function addAttribute(string $attribute, string $value = '') : Base
		{
		if (! isset($this->attributes[$attribute]))
			{
			$this->attributes[$attribute] = $value;
			}
		else
			{
			$this->attributes[$attribute] .= ' ' . $value;
			}

		return $this;
		}

	/**
	 * Add a class to an object
	 *
	 * @param string $class name to add
	 *
	 */
	public function addClass(string $class) : Base
		{
		foreach (explode(' ', $class) as $oneClass)
			{
			$this->classes[] = $oneClass;
			}

		return $this;
		}

	/**
	 * Deletes the attribute
	 *
	 *
	 */
	public function deleteAttribute(string $attribute) : Base
		{
		unset($this->attributes[$attribute]);

		return $this;
		}

	/**
	 * Deletes all attributes
	 *
	 */
	public function deleteAttributes() : Base
		{
		$this->attributes = [];

		return $this;
		}

	/**
	 * Delete a class from the object
	 *
	 *
	 */
	public function deleteClass(string $classToDelete) : Base
		{
		foreach ($this->classes as $key => $class)
			{
			if ($classToDelete == $class)
				{
				unset($this->classes[$key]);

				break;
				}
			}

		return $this;
		}

	/**
	 * Get an attribute
	 *
	 *
	 * @return ?string does not exist if null
	 */
	public function getAttribute(string $attribute) : ?string
		{
		return isset($this->attributes[$attribute]) ? $this->attributes[$attribute] : null;
		}

	/**
	 * Returns the attribute strings
	 *
	 */
	public function getAttributes() : string
		{
		$output = '';

		foreach ($this->attributes as $type => $value)
			{
			if (! strlen($value))
				{
				$output .= ' ' . $type;
				}
			else
				{
				$output .= " {$type}='{$value}'";
				}
			}

		return $output;
		}

	/**
	 * Returns the class attribute
	 *
	 */
	public function getClass() : string
		{
		if (count($this->classes))
			{
			return 'class="' . implode(' ', $this->classes) . '" ';
			}

		return '';
		}

	/**
	 * Returns all classes for the object
	 *
	 */
	public function getClasses() : array
		{
		return $this->classes;
		}

	/**
	 * Return the id of the object
	 *
	 * @return string
	 */
	public function getId()
		{
		if (null === $this->id)
			{
			$this->newId();
			}

		return $this->id;
		}

	/**
	 * Return the id of the object
	 *
	 * @return string
	 */
	public function getIdAttribute()
		{
		if (! $this->hasId())
			{
			return '';
			}

		return "id='{$this->id}' ";
		}

	/**
	 * Return true if the class is present on the object
	 *
	 *
	 */
	public function hasClass(string $hasClass) : bool
		{
		foreach ($this->classes as $class)
			{
			if ($hasClass == $class)
				{
				return true;
				}
			}

		return false;
		}

	/**
	 * Is the id set
	 *
	 */
	public function hasId() : bool
		{
		return null !== $this->id;
		}

	/**
	 * Assign and auto increment the master id
	 *
	 * @return Base
	 */
	public function newId()
		{
		++self::$masterId;
		$this->id = 'id' . self::$masterId;

		return $this;
		}

	/**
	 * Set the attribute overwriting the prior value
	 *
	 * @param string $value of the attribute, blank for just a plain attribute
	 *
	 */
	public function setAttribute(string $attribute, string $value = '') : Base
		{
		$this->attributes[$attribute] = $value;

		return $this;
		}

	/**
	 * Set the base id of the object
	 *
	 * @param string $id id will have 'id' prepended to it when retrieved
	 *
	 */
	public function setId($id) : Base
		{
		$this->id = $id;

		return $this;
		}

	/**
	 *  Transfers attributes into this object from the passed object
	 *
	 *
	 */
	public function transferAttributes(Base $from) : Base
		{
		$this->attributes = array_merge($this->attributes, $from->attributes);
		$from->attributes = [];

		return $this;
		}

	/**
	 *  Transfers attributes into this object from the passed object
	 *
	 *
	 */
	public function transferClasses(Base $from) : Base
		{
		$this->classes = array_merge($this->classes, $from->classes);
		$from->classes = [];

		return $this;
		}

	/**
	 * Clones the first object and fills it with properties from the second object
	 */
	protected function upCastCopy(Base $to, Base $from) : Base
		{
		$returnValue = clone $to;

		foreach ($to as $key => $value)
			{
			$returnValue->{$key} = $from->{$key};
			}

		return $returnValue;
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
