<?php

namespace PHPFUI;

class Orbit extends \PHPFUI\HTML5Element
	{
	private $animation;

	private $bullets;

	private $container;

	private $controls;

	private $started = false;

	private $wrapper;

	public function __construct(string $label = 'Photo Carousel')
		{
		parent::__construct('div');
		$this->addClass('orbit');
		$this->addAttribute('role', 'region');
		$this->addAttribute('aria-label', $label);
		$this->addAttribute('data-orbit');
		$this->container = new UnorderedList();
		$this->container->addClass('orbit-container');
		$this->wrapper = new HTML5Element('div');
		$this->wrapper->addClass('orbit-wrapper');
		$this->add($this->wrapper);
		$this->bullets = new HTML5Element('nav');
		$this->bullets->addClass('orbit-bullets');
		}

	public function addHTMLSlide(HTML5Element $html, bool $active = false) : Orbit
		{
		$item = new ListItem();
		$item->addClass('orbit-slide');

		if ($active)
			{
			$item->addClass('is-active');
			}

		$div = new HTML5Element('div');
		$div->add($html);
		$item->add($div);
		$this->container->addItem($item);
		$this->addBullet($active);

		return $this;
		}

	public function addImageSlide(Image $image, string $caption = '', bool $active = false) : Orbit
		{
		$item = new ListItem();
		$item->addClass('orbit-slide');

		if ($active)
			{
			$item->addClass('is-active');
			}

		$figure = new HTML5Element('figure');
		$figure->addClass('orbit-figure');
		$image->addClass('orbit-image');
		$figure->add($image);

		if ($caption)
			{
			$cap = new HTML5Element('figcaption');
			$cap->addClass('orbit-caption');
			$cap->add($caption);
			$figure->add($cap);
			}

		$item->add($figure);
		$this->container->addItem($item);
		$this->addBullet($active);

		return $this;
		}

	public function getControls() : HTML5Element
		{
		$this->controls = new HTML5Element('div');
		$this->controls->addClass('orbit-controls');
		$this->controls->add('<button class="orbit-previous"><span class="show-for-sr">Previous Slide</span>&#9664;&#xFE0E;</button>');
		$this->controls->add('<button class="orbit-next"><span class="show-for-sr">Next Slide</span>&#9654;&#xFE0E;</button>');

		return $this->controls;
		}

	public function noBullets() : Orbit
		{
		$this->bullets = null;

		return $this;
		}

	public function setAnimation(string $inLeft = 'slide-in-right', string $inRight = 'slide-in-left', string $outLeft = 'slide-out-left', string $outRight = 'slide-out-right') : Orbit
		{
		$this->animation = "animInFromLeft:{$inLeft};animInFromRight:{$inRight};animOutToLeft:{$outLeft};animOutToRight:{$outRight};";

		return $this;
		}

	protected function getStart() : string
		{
		if (! $this->started)
			{
			$this->started = true;

			if (! $this->controls)
				{
				$this->wrapper->add($this->getControls());
				}

			if ($this->animation)
				{
				$this->addAttribute('data-options', $this->animation);
				}
			else
				{
				$this->addAttribute('data-use-m-u-i', 'false');
				}

			$this->wrapper->add($this->container);

			if ($this->bullets)
				{
				$this->add($this->bullets);
				}
			}

		return parent::getStart();
		}

	private function addBullet(bool $active) : void
		{
		if ($this->bullets)
			{
			$button = new HTML5Element('button');
			$number = $this->bullets->count();
			$button->addAttribute('data-slide', $number++);
			$button->add("<span class='show-for-sr'>Slide {$number}</span>");

			if ($active)
				{
				$button->addClass('is-active');
				$button->add('<span class="show-for-sr"> Current Slide</span>');
				}

			$this->bullets->add($button);
			}
		}
	}
