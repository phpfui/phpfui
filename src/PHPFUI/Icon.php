<?php

namespace PHPFUI;

/**
 * Wrapper for Font Awesome icons
 */
class Icon extends HTML5Element
	{
	private $link;

	/**
	 * Construct an Icon.
	 *
	 * @param string $icon the bare name of the icon as documented
	 *               by Font Awesome
	 * @param string $link optional link
	 */
	public function __construct(string $icon, string $link = '')
		{
		$this->link = $link;
		parent::__construct('i');
		$this->addClass('fa');
		$this->addClass('fa-2x');
		$this->addClass('fa-' . $icon);
		}

	/**
	 * returns the current link
	 *
	 */
	public function getLink() : string
		{
		return $this->link;
		}

	/**
	 * Set the link
	 *
	 *
	 */
	public function setLink(string $link) : Icon
		{
		$this->link = $link;

		return $this;
		}

	protected function getEnd() : string
		{
		$output = parent::getEnd();

		if ($this->link)
			{
			$output .= '</a>';
			}

		return $output;
		}

	protected function getStart() : string
		{
		$output = '';

		if ($this->link)
			{
			$id = $this->getId();
			$link = '';

			if ('#' != $this->link)
				{
				$link = "href='{$this->link}' ";
				}

			$output = "<a id='{$id}a' {$link}>";
			}

		return $output . $this->getToolTip(parent::getStart());
		}
	}
