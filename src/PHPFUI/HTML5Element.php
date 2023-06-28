<?php

namespace PHPFUI;

/**
 * The basic HTML5Element that handles common Foundation things and HTML closing tags
 *
 */
class HTML5Element extends \PHPFUI\Base
	{
	/** @var array<string, string> */
	private array $attributes = [];

	/** @var array<string, true> */
	private array $classes = [];

	private string $element = '';

	private ?string $id = null;

	/** @var array<string, int> */
	private static array $masterId = [];

	private bool $noEndTag = false;

	/** @var array<string, true> */
	private static array $noEndTags = [
		'area' => true,
		'base' => true,
		'br' => true,
		'col' => true,
		'command' => true,
		'embed' => true,
		'hr' => true,
		'img' => true,
		'input' => true,
		'keygen' => true,
		'link' => true,
		'meta' => true,
		'param' => true,
		'source' => true,
		'track' => true,
		'wbr' => true,
	];

	private string | \PHPFUI\ToolTip | null $tooltip = null;

	/**
	 * Construct an object with the tag name, ie. DIV, SPAN, TEXTAREA, etc
	 */
	public function __construct(string $element)
		{
		parent::__construct();
		$this->element = \strtolower($element);
		$this->noEndTag = isset(self::$noEndTags[$this->element]);
		}

	public function __clone()
		{
		if ($this->hasId())
			{
			$this->newId();
			}
		parent::__clone();
		}

	/**
	 * Add an attribute the the object
	 *
	 * @param string $value of the attribute, blank for just a plain attribute
	 */
	public function addAttribute(string $attribute, string $value = '') : static
		{
		if (! isset($this->attributes[$attribute]))
			{
			$this->attributes[$attribute] = (string)$value;
			}
		else
			{
			$this->attributes[$attribute] .= " {$value}";
			}

		return $this;
		}

	/**
	 * Add a class to an object
	 *
	 * @param string $class name(s) to add
	 */
	public function addClass(string $class) : static
		{
		foreach (\explode(' ', $class) as $oneClass)
			{
			if ($oneClass)
				{
				$this->classes[$oneClass] = true;
				}
			}

		return $this;
		}

	/**
	 * Adds the base PHP class name as a class to this object
	 */
	public function addPHPClassName() : static
		{
		$parts = \explode('\\', static::class);
		$this->classes[\array_pop($parts)] = true;

		return $this;
		}

	/**
	 * Deletes the passed attribute
	 */
	public function deleteAttribute(string $attribute) : static
		{
		unset($this->attributes[$attribute]);

		return $this;
		}

	/**
	 * Deletes all attributes
	 */
	public function deleteAttributes() : static
		{
		$this->attributes = [];

		return $this;
		}

	/**
	 * Delete a class from the object
	 */
	public function deleteClass(string $classToDelete) : static
		{
		unset($this->classes[$classToDelete]);

		return $this;
		}

	/**
	 * Disabled the element
	 */
	public function disabled() : static
		{
		$this->addClass('disabled');

		return $this;
		}

	/**
	 * Get an attribute
	 *
	 * @return ?string does not exist if null
	 */
	public function getAttribute(string $attribute) : ?string
		{
		return $this->attributes[$attribute] ?? null;
		}

	/**
	 * Returns the attribute strings. Attributes with values are returned as name/value pairs,
	 * attributes without values are returned as just the attribute name.
	 */
	public function getAttributes() : string
		{
		$output = '';

		foreach ($this->attributes as $type => $value)
			{
			if (! \strlen(\trim($value)))
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
	 * Returns the class attribute ready for insertion into an element.
	 */
	public function getClass() : string
		{
		if (\count($this->classes))
			{
			return " class='" . \implode(' ', \array_keys($this->classes)) . "'";
			}

		return '';
		}

	/**
	 * Returns all classes for the object
	 *
	 * @return array<string>
	 */
	public function getClasses() : array
		{
		return \array_keys($this->classes);
		}

	/**
	 * Return the type of the element
	 */
	public function getElement() : string
		{
		return $this->element;
		}

	/**
	 * Return the id of the object. Elements will not have an id unless this method is called. The id is returned as a string
	 * starting with id followed by a unique number to the page. Id numbers are deterministic and start start with 1. Once assigned
	 * an id, an element will always have the same id. It will get a new id if cloned.
	 */
	public function getId() : string
		{
		if (null === $this->id)
			{
			$this->newId();
			}

		return $this->id;
		}

	/**
	 * Return the id attribute of the object as a name/value pair. If no id has been requested, and empty string is returned.
	 */
	public function getIdAttribute() : string
		{
		if (! $this->hasId())
			{
			return '';
			}

		return " id='{$this->id}'";
		}

	/**
	 * Get the tool tip as a string
	 *
	 * @return ToolTip|string return type depends on if the tip was set as a string or ToolTip object.
	 */
	public function getToolTip(string $label) : string | \PHPFUI\ToolTip
		{
		$toolTip = $label;

		if ($this->tooltip)
			{
			if ('string' == \gettype($this->tooltip))
				{
				$toolTip = new \PHPFUI\ToolTip($label, $this->tooltip);
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
	 * Return true if the class is present on the object
	 */
	public function hasClass(string $class) : bool
		{
		return isset($this->classes[$class]);
		}

	/**
	 * Does this object have an id set already?
	 */
	public function hasId() : bool
		{
		return null !== $this->id;
		}

	/**
	 * @return bool if there is a tool tip associated with this element
	 */
	public function hasToolTip() : bool
		{
		return null !== $this->tooltip;
		}

	/**
	 * Assign a new id to this element.
	 */
	public function newId() : static
		{
		$parts = \explode('\\', static::class);
		$class = \array_pop($parts);
		self::$masterId[$class] ??= 0;
		$this->id = $class . ++self::$masterId[$class];

		return $this;
		}

	/**
	 * Set the attribute overwriting the prior value
	 *
	 * @param string $value of the attribute, blank for just a plain attribute
	 */
	public function setAttribute(string $attribute, string $value = '') : static
		{
		$this->attributes[$attribute] = (string)$value;

		return $this;
		}

	/**
	 * A simple way to set a confirm on click
	 *
	 * @param string $text confirm text
	 */
	public function setConfirm($text) : static
		{
		$this->addAttribute('onclick', "return window.confirm(\"{$text}\");");

		return $this;
		}

	/**
	 * You can set the element type if you need to morph it for some reason
	 *
	 * @param string $element
	 */
	public function setElement($element) : static
		{
		$this->element = $element;
		$this->noEndTag = isset(self::$noEndTags[\strtolower($element)]);

		return $this;
		}

	/**
	 * Set the base id of the object
	 *
	 * @param string $id to set. Will be returned as set. It is up to the caller to prevent duplicate ids.
	 */
	public function setId($id) : static
		{
		$this->id = $id;

		return $this;
		}

	/**
	 * Set the tool tip.  Can either be a ToolTip or a string.  If it is a string, it will be converted to a ToolTip
	 */
	public function setToolTip(string | \PHPFUI\ToolTip $tip) : static
		{
		$this->tooltip = $tip;

		return $this;
		}

	/**
	 * Will toggle the provided element on click with the provided animation.
	 */
	public function toggleAnimate(\PHPFUI\HTML5Element $element, string $animation) : static
		{
		$this->addAttribute('data-toggle', $element->getId());
		$this->addAttribute('aria-controls', $element->getId());
		$this->setAttribute('aria-expanded', 'true');
		$element->addAttribute('data-toggler');
		$element->addAttribute('data-animate', $animation);

		return $this;
		}

	/**
	 * Will toggle the class on the provided element on click.
	 */
	public function toggleClass(\PHPFUI\HTML5Element $element, string $class) : static
		{
		$this->addAttribute('data-toggle', $element->getId());
		$this->addAttribute('aria-controls', $element->getId());
		$this->setAttribute('aria-expanded', 'true');
		$element->addAttribute('data-toggler', $class);

		return $this;
		}

	/**
	 *  Moves attributes into this object from the passed object
	 */
	public function transferAttributes(\PHPFUI\HTML5Element $from) : static
		{
		$this->attributes = \array_merge($this->attributes, $from->attributes);
		$from->attributes = [];

		return $this;
		}

	/**
	 *  Moves classes into this object from the passed object
	 */
	public function transferClasses(\PHPFUI\HTML5Element $from) : static
		{
		$this->classes = \array_merge($this->classes, $from->classes);
		$from->classes = [];

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

		$output = "<{$this->element}";
		$output .= $this->getIdAttribute();
		$output .= $this->getClass();
		$output .= $this->getAttributes();

		return $output . '>';
		}

	/**
	 * Clones the first object and fills it with properties from the second object
	 */
	protected function upCastCopy(\PHPFUI\HTML5Element $to, HTML5Element $from) : object
		{
		$returnValue = clone $to;

		// @phpstan-ignore-next-line
		foreach ($to as $key => $value)
			{
			$returnValue->{$key} = $from->{$key};
			}

		return $returnValue;
		}
	}
