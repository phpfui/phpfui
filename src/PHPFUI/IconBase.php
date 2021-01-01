<?php

namespace PHPFUI;

/**
 * Wrapper for icons
 *
 * @depreciated 6.1.0 IconBase will become Icon
 */
class IconBase extends \PHPFUI\HTML5Element
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
		$this->addClass($icon);
		}

	/**
	 * returns the current link
	 */
	public function getLink() : string
		{
		return $this->link;
		}

	/**
	 * Set the link
	 */
	public function setLink(string $link) : Icon
		{
		$this->link = $link;

		return $this;
		}

	protected function getEnd() : string
		{
		return $this->link ? '</a>' : '';
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

			$target = $this->getAttribute('target');

			if ($target)
				{
				$target = "target='{$target}' ";
				}
			$output = "<a {$target}id='{$id}a' {$link}>";
			}
		$this->deleteAttribute('target');

		return $output . $this->getToolTip(parent::getStart() . parent::getBody() . parent::getEnd());
		}
	}
