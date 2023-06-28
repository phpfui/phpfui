<?php

namespace PHPFUI\Traits;

/**
 * Walkable interface allows you to apply the same method to all objects with that method in the container.
 */
trait Walkable
	{
	/**
	 * Recursively walks all objects and calls the passed method on each object where it exists
	 *
	 * @param string $method to call on the object in the collection
	 * @param mixed $argument to pass to the method
	 */
	public function walk(string $method, mixed $argument = null) : static
		{
		foreach ($this->items as $item)
			{
			if (\is_object($item))
				{
				if (\method_exists($item, $method))
					{
					if (null !== $argument)
						{
						\call_user_func([$item, $method], $argument);
						}
					else
						{
						\call_user_func([$item, $method]);
						}
					}

				if ($item instanceof \PHPFUI\Base || $item instanceof \PHPFUI\Container || $item instanceof \PHPFUI\Menu) // @phpstan-ignore-line
					{
					$item->walk($method, $argument);
					}
				}
			}

		return $this;
		}
	}
