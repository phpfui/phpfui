<?php

namespace PHPFUI;

class MenuItem extends \PHPFUI\HTML5Element
	{
	private bool $active = false;

	private string $align = '';

	private ?\PHPFUI\Link $generatedLink = null;

	private ?\PHPFUI\Base $graphic = null;

	private bool $started = false;

	public function __construct(private string $name = '', private string $link = '')
		{
		parent::__construct('li');
		}

	public function getActive() : bool
		{
		return $this->active;
		}

	/**
	 * returns the icon or image if set
	 */
	public function getGraphic(\PHPFUI\Base $graphic) : Base
		{
		return $this->graphic;
		}

	public function getLink() : string
		{
		return $this->link;
		}

	/**
	 * Get the link as a \PHPFUI\Link from the MenuItem
	 *
	 * Due to the need to be able to add images to a MenuItem, getLink should only be called after the icon or image is set,
	 * otherwise the graphic will not be rendered.
	 */
	public function getLinkObject() : ?Link
		{
		if ($this->generatedLink)
			{
			return $this->generatedLink;
			}

		$name = $this->name;

		if ('' !== $this->link && $this->graphic)
			{
			if (\in_array($this->align, ['right', 'bottom']))
					{
					$name = "<span>{$name}</span> {$this->graphic}";
					}
				else
					{
					$name = "{$this->graphic} <span>{$name}</span>";
					}
			}
		$this->generatedLink = new \PHPFUI\Link($this->link, $name, false);

		return $this->generatedLink;
		}

	public function getName() : string
		{
		return $this->name;
		}

	public function setActive(bool $active = true) : static
		{
		$this->active = $active;

		return $this;
		}

	public function setAlignment(string $align) : static
		{
		$this->align = $align;

		return $this;
		}

	/**
	 * Set a menu graphic other than an icon or image
	 */
	public function setGraphic(Base $graphic) : static
		{
		$this->graphic = $graphic;

		return $this;
		}

	public function setIcon(IconBase $icon) : static
		{
		$this->graphic = $icon;

		return $this;
		}

	public function setImage(Image $image) : static
		{
		$this->graphic = $image;

		return $this;
		}

	public function setLink(string $link) : static
		{
		$this->link = $link;

		return $this;
		}

	/**
	 * You can set the link object directly if needed to set specific properties
	 */
	public function setLinkObject(Link $linkObject) : static
		{
		$this->generatedLink = $linkObject;

		return $this;
		}

	public function setName(string $name) : static
		{
		$this->name = $name;

		return $this;
		}

	protected function getStart() : string
		{
		if (! $this->started)
			{
			$this->started = true;

			if ($this->active)
				{
				$this->addClass('is-active');
				}

			if ($this->link)
				{
				$text = $this->getLinkObject();
				}
			else
				{
				$this->addClass('menu-text');
				$text = $this->name;
				}

			$this->prepend($text);
			}

		return parent::getStart();
		}
	}
