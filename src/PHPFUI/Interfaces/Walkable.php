<?php

namespace PHPFUI\Interfaces;

/**
 * Walkable interface allows you to apply the same method to all objects with that method in the container.
 */
interface Walkable
	{
	public function walk(string $method, mixed $argument = null) : static;
	}
