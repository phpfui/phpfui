<?php

namespace PHPFUI;

/**
 * Simple wrapper for DropDown links
 */
class DropDown extends \PHPFUI\Base
	{
	private \PHPFUI\HTML5Element $dropDown;

	private bool $hover = false;

	/**
	 * Construct a DropDown
	 *
	 * @param HTML5Element $dropTarget what to click on to initite drop down
	 * @param HTML5Element $dropDown what you are going to drop
	 */
	public function __construct(\PHPFUI\HTML5Element $dropTarget, HTML5Element $dropDown)
		{
		parent::__construct();
		$this->dropDown = $dropDown;
		$this->dropDown->addClass('dropdown-pane');
		$this->dropDown->addAttribute('data-dropdown');
		$dropTarget->addAttribute('data-toggle', $this->dropDown->getId());
		$this->add($dropTarget);
		}

	/**
	 * Set the alignment of the drop down
	 *
	 * @param string $alignment must be one of left, center, right
	 */
	public function setAlignment(string $alignment) : DropDown
		{
		$validAlignments = ['left',
			'center',
			'right', ];

		if (! \in_array($alignment, $validAlignments))
			{
			throw new \Exception(__METHOD__ . ': $alignment must be one of (' . \implode(',', $validAlignments) . ')');
			}

		$this->dropDown->setAttribute('data-alignment', $alignment);

		return $this;
		}

	/**
	 * DropDown on hover
	 *
	 * @param bool $hover default true
	 */
	public function setHover(bool $hover = true) : DropDown
		{
		$this->hover = $hover;

		return $this;
		}

	/**
	 * Set the position of the drop down (drop up anyone?)
	 *
	 * @param string $position must be one of top, bottom, left, right
	 */
	public function setPosition(string $position) : DropDown
		{
		$validPositions = ['top',
			'bottom',
			'left',
			'right', ];

		if (! \in_array($position, $validPositions))
			{
			throw new \Exception(__METHOD__ . ': $position must be one of (' . \implode(',', $validPositions) . ')');
			}

		$this->dropDown->setAttribute('data-position', $position);

		return $this;
		}

	protected function getBody() : string
		{
		return '';
		}

	protected function getEnd() : string
		{
		return "{$this->dropDown}";
		}

	protected function getStart() : string
		{
		if ($this->hover)
			{
			$this->dropDown->setAttribute('data-hover', 'true');
			$this->dropDown->setAttribute('data-hover-pane', 'true');
			}
		else
			{
			$this->dropDown->setAttribute('data-auto-focus', 'true');
			}

		return '';
		}
	}
