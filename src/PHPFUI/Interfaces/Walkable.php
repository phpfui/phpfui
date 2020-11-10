<?php

namespace PHPFUI\Interfaces;

/**
 * Walkable interface allows you to apply the same method to all objects with that method in the container.
 */
interface Walkable
	{

	/**
	 * @param \PHPFUI\Interfaces\Page $page current page
	 * @param string $id of the textarea that ends editing support
	 *
	 * @return $this
	 */
	public function walk(string $method, $argument = null);

	}
