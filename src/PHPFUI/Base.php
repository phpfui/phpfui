<?php

namespace PHPFUI;

/**
 * Abstract base class for most PHPFUI classes
 *
 * Overrides string output for easy output and concatination
 */
abstract class Base implements \Countable
	{
	private $attributes = [];
	private $classes = [];
	private static $debug = false;
	private static $done = false;
	private $id = null;
	private $items = [];
	private static $masterId = 0;

	private static $response = '';

	public function __construct()
		{
		}

	public function __clone()
		{
		if ($this->hasId())
			{
			$this->newId();
			}

		foreach ($this->items as $key => $item)
			{
			if (is_object($item))
				{
				$this->items[$key] = clone $item;
				}
			}
		}

	/**
	 * Convert to string
	 *
	 */
	public function __toString() : string
		{
		try
			{
			return $this->output();
			} catch (\Exception $e)
			{
			return $e->getMessage();
			}
		}

	/**
	 * Base add function.  Adds to the end of the current objects
	 *
	 * @param mixed $item should be convertable to string
	 *
	 * @return Base
	 */
	public function add($item)
		{
		if (null !== $item)
			{
			$this->items[] = $item;
			}

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
	 * Number of object in this object.  Does not count sub objects.
	 *
	 */
  public function count() : int
		{
		return count($this->items);
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
	 * Form is done rendering
	 *
	 */
	public function done(bool $done = true) : Base
		{
		self::$done = $done;

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

	public static function getDebug() : bool
		{
		return self::$debug;
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
	 * Get the current response
	 *
	 */
	public function getResponse() : string
		{
		return self::$response;
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
	 * Returns true if the page needs no more processing
	 *
	 */
	public function isDone() : bool
		{
		return self::$done;
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
	 * Output the object (convert to string)
	 *
	 * @return string
	 */
	public function output()
		{
		if (self::$done)
			{
			return self::$response;
			}

		$output = '';
		try
			{
			$output .= "{$this->getStart()}";

			if (self::$debug && $output)
				{
				$output .= "\n";
				}

			foreach ($this->items as $item)
				{
				$output .= "{$item}";

				if (self::$debug && $item)
					{
					$output .= "\n";
					}
				}
			$body = "{$this->getBody()}";
			$output .= $body;

			if (self::$debug && $body)
				{
				$output .= "\n";
				}
			$end = "{$this->getEnd()}";
			$output .= $end;

			if (self::$debug && $end)
				{
				$output .= "\n";
				}
			}
		catch (\Exception $e)
			{
			$output .= $e->getMessage();
			}

		return $output;
		}

	/**
	 * Add an object in front of existing object
	 *
	 *
	 */
	public function prepend($item) : Base
		{
		array_unshift($this->items, $item);

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

	public static function setDebug(bool $debug = true) : void
		{
		self::$debug = $debug;
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
	 * Sets the page response directly
	 *
	 *
	 */
	public function setRawResponse(string $response) : Base
		{
		if (! self::$response)
			{
			self::$response = $response;
			$this->done();
			header('Content-Type: application/json');
			}

		return $this;
		}

	/**
	 * Set a response in the standard format ('reponse' and 'color' array)
	 *
	 * @param string $color used for the save button
	 *
	 */
	public function setResponse(string $response, string $color = 'lime') : Base
		{
		if (! self::$response)
			{
			self::$response = json_encode(['response' => $response,
																		 'color'    => $color,]);
			$this->done();
			header('Content-Type: application/json');
			}

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
	 * You must provide a getBody function.  It will be called after start and before end.
	 *
	 */
  abstract protected function getBody() : string;

  /**
	 * You must provide a getEnd function.  It will be called last on output.
	 *
	 */
  abstract protected function getEnd() : string;

	/**
	 * You must provide a getStart function.  It will be called first on output.
	 *
	 */
	abstract protected function getStart() : string;

  /**
	 * Clones the first object and fills it with properties from the second object
	 *
	 *
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

  /**
	 * Walks all objects and applies the passed function
	 *
	 *
	 */
  protected function walk(callable $function, $data = null) : Base
		{
		array_walk($this->items, $function, $data);

		return $this;
		}

  }
