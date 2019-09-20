<?php

namespace PHPFUI;

/**
 * Wrapper for a carousel http://kenwheeler.github.io/slick/
 */
class SlickSlider extends HTML5Element
	{
	private $attributes = [];

	private $page;
	private $slides = [];

	/**
	 * Construct a SlickSlider carousel
	 *
	 * @param Page $page to add JS
	 */
	public function __construct(Page $page)
		{
		parent::__construct('div');
		$this->addClass('slick-slider');
		$this->page = $page;
		$page->addStyleSheet('/slick/slick.css');
		$page->addStyleSheet('/slick/slick-theme.css');
		$page->addTailScript('/slick/slick.min.js');
		}

	/**
	 * Add an image and alt text to the slider
	 *
	 * @param string $image path/filename of image to add
	 * @param string $alt text
	 */
	public function addImage(string $image, string $alt = '') : SlickSlider
		{
		$extra = '';

		if (empty($alt))
			{
			$alt = $image;
			}
		else
			{
			$extra = "<div>{$alt}</div>";
			}

		return $this->addSlide("<img src='{$image}' alt='{$alt}'>{$extra}");
		}

	/**
	 * Add a free form slide
	 */
	public function addSlide(string $html) : SlickSlider
		{
		$this->slides[] = $html;

		return $this;
		}

	/**
	 * Add an attribute as defined by the slider
	 *
	 * @param mixed $value of any type
	 *
	 */
	public function addSliderAttribute(string $attribute, $value = '') : Base
		{
		$this->attributes[$attribute] = $value;

		return $this;
		}

	protected function getBody() : string
		{
		$active = ' class="slick-slide slick-current slick-active" aria-hidden="false"';
		$output = '';

		foreach ($this->slides as $slide)
			{
			$output .= "<div{$active}>{$slide}</div>";
			$active = ' class="slick-slide" aria-hidden="true"';
			}

		return $output;
		}

	protected function getStart() : string
		{
		$js = '$("#' . $this->getId() . '").slick(' . \PHPFUI\TextHelper::arrayToJS($this->attributes) . ');$(".slick-slider").show();';
		$this->page->addJavaScript($js);

		return parent::getStart();
		}
	}
