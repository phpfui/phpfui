<?php

namespace PHPFUI;

class OffCanvas extends \PHPFUI\Base
	{
	private \PHPFUI\HTML5Element $mainContent;

	private \PHPFUI\HTML5Element $offCanvas;

	private array $offCanvasCollection = [];

	private bool $wrapper = false;

	public function __construct(\PHPFUI\HTML5Element $mainContent)
		{
		$this->mainContent = $mainContent;
		$this->offCanvas = new \PHPFUI\HTML5Element('div');
		$this->offCanvas->addClass('off-canvas');
		$this->offCanvas->addAttribute('data-off-canvas');
		}

	/**
	 * Add something off the canvas to come in when the toggle is
	 * activated.
	 *
	 * @param HTML5Element $content what you want to slide in from
	 *                     off canvas
	 * @param HTML5Element $toggle what to toggle to get the off
	 *                     canvas piece to slide in
	 *
	 * @return string id of the content added. Used to specify
	 *         postion and transition attributes
	 */
	public function addOff(\PHPFUI\HTML5Element $content, HTML5Element $toggle) : string
		{
		$toggle->addAttribute('data-toggle', $this->offCanvas->getId());
		$id = $content->getId();
		$this->offCanvasCollection[$id] = $content;

		return $id;
		}

	public function addWrapper() : OffCanvas
		{
		$this->wrapper = true;

		return $this;
		}

	/**
	 * Set the incoming canvas position
	 *
	 * @param string $id id from addOff when the off canvas was
	 *               added.
	 * @param string $position one of ['left', 'right', 'top',
	 *               'bottom']
	 */
	public function setPosition(string $id, string $position) : OffCanvas
		{
		$this->validateId($id);
		$positions = ['left',
			'right',
			'top',
			'bottom', ];

		if (! \in_array($position, $positions))
			{
			throw new \Exception(__METHOD__ . ": {$position} must be one of " . \implode(',', $positions));
			}

		$this->offCanvas->addClass("position-{$position}");

		return $this;
		}

	/**
	 * Set the transition canvas position
	 *
	 * @param string $id id from addOff when the off canvas was
	 *               added.
	 * @param string $transition one of ['over', 'push']
	 */
	public function setTransition(string $id, string $transition) : OffCanvas
		{
		$this->validateId($id);
		$transitions = ['over',
			'push', ];

		if (! \in_array($transition, $transitions))
			{
			throw new \Exception(__METHOD__ . ": {$transition} must be one of " . \implode(',', $transitions));
			}

		$this->offCanvas->setAttribute('data-transition', $transition);

		return $this;
		}

	protected function getBody() : string
		{
		if ($this->wrapper)
			{
			$wrapper = new \PHPFUI\HTML5Element('div');
			$wrapper->addClass('');
			$wrapper->addClass('off-canvas-wrapper');
			}
		else
			{
			$wrapper = new \PHPFUI\Container();
			}

		foreach ($this->offCanvasCollection as $id => $off)
			{
			$this->offCanvas->add($off);
			}

		$mainContent = new \PHPFUI\HTML5Element('div');
		$mainContent->addClass('off-canvas-content');
		$mainContent->addAttribute('data-off-canvas-content');
		$mainContent->add($this->mainContent);

		$wrapper->add($this->offCanvas);
		$wrapper->add($mainContent);

		return $wrapper;
		}

	protected function getEnd() : string
		{
		return '';
		}

	protected function getStart() : string
		{
		return '';
		}

	private function validateId(string $id) : OffCanvas
		{
		if (! isset($this->offCanvasCollection[$id]))
			{
			throw new \Exception(__CLASS__ . ": OffCanvas id ({$id}) is not valid");
			}

		return $this;
		}
	}
