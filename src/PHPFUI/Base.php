<?php

namespace PHPFUI;

/**
 * Abstract base class for most PHPFUI classes
 *
 * Overrides string output for easy output and concatination
 */
abstract class Base implements \Countable, \PHPFUI\Interfaces\Walkable
	{
	use \PHPFUI\Traits\Walkable;

	public const DEBUG_SOURCE = 1;

	private static int $debug = 0;

	private static bool $done = false;

	private array $items = [];

	private static string $response = '';

	public function __construct()
		{
		}

	public function __clone()
		{
		foreach ($this->items as $key => $item)
			{
			if (\is_object($item))
				{
				$this->items[$key] = clone $item;
				}
			}
		}

	public function __toString() : string
		{
		try
			{
			return $this->output();
			}
		catch (\Exception $e)
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
	 * Base addAsFirst function.  Adds to the front of the current
	 * object
	 *
	 * @param mixed $item should be convertable to string
	 *
	 * @return Base
	 */
	public function addAsFirst($item)
		{
		if (null !== $item)
			{
			\array_unshift($this->items, $item);
			}

		return $this;
		}

	/**
	 * Number of object in this object.  Does not count sub objects.
	 */
	public function count() : int
		{
		return \count($this->items);
		}

	/**
	 * Form is done rendering
	 */
	public function done(bool $done = true) : Base
		{
		self::$done = $done;

		return $this;
		}

	/**
	 * Gets the current debug setting
	 */
	public static function getDebug(int $flags = 0) : int
		{
		if ($flags)
			{
			return self::$debug & $flags;
			}

		return self::$debug;
		}

	/**
	 * Get the current response
	 */
	public function getResponse() : string
		{
		return self::$response;
		}

	/**
	 * Returns true if the page needs no more processing
	 */
	public function isDone() : bool
		{
		return self::$done;
		}

	/**
	 * Add an object in front of existing object
	 */
	public function prepend($item) : Base
		{
		\array_unshift($this->items, $item);

		return $this;
		}

	/**
	 * Set the debug level, 1 or higher is on
	 */
	public static function setDebug(int $level = 0) : void
		{
		if ($level)
			{
			self::$debug |= $level;
			}
		else
			{
			self::$debug = 0;
			}
		}

	/**
	 * Sets the page response directly
	 */
	public function setRawResponse(string $response, bool $asJSON = true) : Base
		{
		if (! $this->isDone())
			{
			self::$response = $response;
			$this->done();

			if ($asJSON)
				{
				\header('Content-Type: application/json');
				}
			}

		return $this;
		}

	/**
	 * Set a response in the standard format ('reponse' and 'color' array)
	 *
	 * @param string $response to return
	 * @param string $color used for the save button
	 */
	public function setResponse(string $response, string $color = 'lime') : Base
		{
		if (! $this->isDone())
			{
			$this->setRawResponse(\json_encode(['response' => $response, 'color' => $color, ]));
			}

		return $this;
		}

	protected function getItems() : array
		{
		return $this->items;
		}

	/**
	 * You must provide a getBody function.  It will be called after start and before end.
	 */
	abstract protected function getBody() : string;

	/**
	 * You must provide a getEnd function.  It will be called last on output.
	 */
	abstract protected function getEnd() : string;

	/**
	 * You must provide a getStart function.  It will be called first on output.
	 */
	abstract protected function getStart() : string;

	/**
	 * Output the object (convert to string)
	 *
	 */
	private function output() : string
		{
		if ($this->isDone())
			{
			return self::$response;
			}

		$output = '';

		$debug = self::getDebug(\PHPFUI\Session::DEBUG_HTML) ? "\n" : '';

		try
			{
			$output .= "{$this->getStart()}";

			if ($output)
				{
				$output .= $debug;
				}

			foreach ($this->items as $item)
				{
				$output .= "{$item}";

				if ($item)
					{
					$output .= $debug;
					}
				}
			$body = "{$this->getBody()}";
			$output .= $body;

			if ($body)
				{
				$output .= $debug;
				}
			$end = "{$this->getEnd()}";
			$output .= $end;

			if ($end)
				{
				$output .= $debug;
				}
			}
		catch (\Exception $e)
			{
			$output .= $e->getMessage();
			}

		return $output;
		}
	}
