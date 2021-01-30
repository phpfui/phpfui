<?php

namespace PHPFUI;

/**
 * Annimation will validate proper annimation types
 */
class Animation
	{
	private static $animations = [
		'slide-in-down' => true,
		'slide-in-left' => true,
		'slide-in-up' => true,
		'slide-in-right' => true,
		'slide-out-down' => true,
		'slide-out-left' => true,
		'slide-out-up' => true,
		'slide-out-right' => true,
		'fade-in' => true,
		'fade-out' => true,
		'hinge-in-from-top' => true,
		'hinge-in-from-right' => true,
		'hinge-in-from-bottom' => true,
		'hinge-in-from-left' => true,
		'hinge-in-from-middle-x' => true,
		'hinge-in-from-middle-y' => true,
		'hinge-out-from-top' => true,
		'hinge-out-from-right' => true,
		'hinge-out-from-bottom' => true,
		'hinge-out-from-left' => true,
		'hinge-out-from-middle-x' => true,
		'hinge-out-from-middle-y' => true,
		'scale-in-up' => true,
		'scale-in-down' => true,
		'scale-out-up' => true,
		'scale-out-down' => true,
		'spin-in' => true,
		'spin-out' => true,
		'spin-in-ccw' => true,
		'spin-out-ccw' => true,
	];

	/**
	 * Return all valid animation strings
	 */
	public static function allAnimations() : array
		{
		return \array_keys(self::$animations);
		}

	/**
	 * Return true if it is a valid animation type.  Empty string is
	 * valid.
	 */
	public static function isValid(string $animation) : bool
		{
		return empty($animation) || isset(self::$animations[$animation]);
		}
	}
