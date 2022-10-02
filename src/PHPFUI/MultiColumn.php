<?php

namespace PHPFUI;

/**
 * A class to for quick formatting of various elements that
 * should be in one row. It is countable.
 *
 * You often want to place multiple elements on one line. This
 * class does all the heavy lifting to figure out the number of
 * columns needed.
 *
 * It assumes a 12 column page, but the last item will always be
 * added with the auto class, so it should fit any number of
 * columns well. But generally more than 6 items don't work well
 * do to space considerations. The more fields added in a
 * MultiColumn means each one should be more similar in size to
 * the others. Make sure the control you add can scale down to
 * an appropriate size.
 *
 * The constructor can take multiple parameteters. So the
 * following are equivalent:
 * ```
 * $mc = new \PHPFUI\MultiColumn();
 * $mc->add($a);
 * $mc->add($b);
 * $mc->add($c);
 * ```
 * and:
 * ```
 * $mc = new \PHPFUI\MultiColumn($a, $b, $c);
 * ```
 */
class MultiColumn extends \PHPFUI\GridX implements \Countable
	{
	/** @var array<mixed> */
	private array $objects = [];

	private bool $started = false;

	public function __construct()
		{
		parent::__construct();
		$this->setMargin();
		$this->objects = \func_get_args();
		$this->addClass('align-middle');
		}

	/**
	 * Add an element to the container
	 *
	 *
	 */
	public function add(mixed $object) : static
		{
		$this->objects[] = $object;

		return $this;
		}

	/**
	 * Return the number of columns so far
	 *
	 */
	public function count() : int
		{
		return \count($this->objects);
		}

	protected function getStart() : string
		{
		if (! $this->started)
			{
			$this->started = true;

			if ($number = \count($this->objects))
				{
				$sizes = [0, 12, 6, 4, 3, 2, 2, ];

				for ($i = 1; $i <= $number; ++$i)
					{
					$cell = new \PHPFUI\Cell();

					if ($i == $number)
						{
						$cell->setAuto();
						}
					else
						{
						$cell->setSmall($sizes[$number] ?? 1);
						}

					$cell->add($this->objects[$i - 1]);
					parent::add($cell);
					}
				}
			}

		return parent::getStart();
		}
	}
