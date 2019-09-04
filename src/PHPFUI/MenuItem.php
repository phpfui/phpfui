<?php

namespace PHPFUI;

class MenuItem extends HTML5Element
	{
	private $active = false;
	private $align;
	private $graphic;

	private $link;
	private $name;
	private $started = false;

	public function __construct(string $name, string $link = '')
		{
		parent::__construct('li');
		$this->link = $link;
		$this->name = $name;
		}

	public function getActive() : bool
		{
		return $this->active;
		}

	public function getLink() : string
		{
		return $this->link;
		}

	public function getName() : string
		{
		return $this->name;
		}

	public function setActive(bool $active = true) : MenuItem
		{
		$this->active = $active;

		return $this;
		}

	public function setAlignment(string $align) : MenuItem
		{
		$this->align = $align;

		return $this;
		}

	public function setIcon(Icon $icon) : MenuItem
		{
		$this->graphic = $icon;

		return $this;
		}

	public function setImage(Image $image) : MenuItem
		{
		$this->graphic = $image;

		return $this;
		}

	public function setLink(string $link) : MenuItem
		{
		$this->link = $link;

		return $this;
		}

	public function setName(string $name) : MenuItem
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
				$text = new HTML5Element('a');
				$text->addAttribute('href', $this->link);

				if ($this->graphic)
					{
					if (in_array($this->align, ['right',
																			'bottom']))
						{
						$text->add("<span>{$this->name}</span> {$this->graphic}");
						}
					else
						{
						$text->add("{$this->graphic} <span>{$this->name}</span>");
						}
					}
				else
					{
					$text->add($this->name);
					}
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
