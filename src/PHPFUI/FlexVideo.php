<?php

namespace PHPFUI;

/**
 * Simple wrapper for FlexVideo
 */
class FlexVideo extends HTML5Element
	{
	protected $iframe;
	protected $title = '&nbsp;';

	protected $url = '';
	protected $videoBaseUrl = '';

	public function __construct()
		{
		parent::__construct('div');
		$this->addClass('flex-video');
		$this->iframe = new HTML5Element('iframe', $this->getVideoId());
		$this->iframe->addAttribute('frameborder', 0);
		$this->iframe->addAttribute('allowfullscreen');
		}

	/**
	 * Return the id of the title
	 *
	 * @return string
	 */
	public function getTitleId()
		{
		return $this->getId() . '-Title';
		}

	public function getVideoBaseUrl()
		{
		return $this->videoBaseUrl;
		}

	/**
	 * Return a specific id for the video
	 *
	 * @return string
	 */
	public function getVideoId()
		{
		return $this->getId() . '-Video';
		}

	/**
	 * Set the title
	 *
	 * @param string $title
	 *
	 * @return string $title of the video, optional
	 */
	public function setTitle($title)
		{
		$this->title = $title;

		return $this;
		}

	/**
	 * Set the URL for the video
	 *
	 * @param string $url
	 *
	 * @return FlexVideo
	 */
	public function setUrl($url)
		{
		$this->url = $url;

		return $this;
		}

	protected function getBody() : string
		{
		return parent::getBody() . $this->iframe;
		}

	protected function getStart() : string
		{
		$this->iframe->addAttribute('src', $this->url);
		$this->iframe->transferAttributes($this);
		$title = new HTML5Element('h3', $this->getTitleId());
		$title->add($this->title);

		return $title . parent::getStart();
		}

	}
