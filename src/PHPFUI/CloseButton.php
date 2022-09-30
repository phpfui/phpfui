<?php

namespace PHPFUI;

class CloseButton extends \PHPFUI\Button
	{
	/**
	 * Add a CloseButton to objects you want to show as closeable.
	 * Use the closeAction to specify any animation you want on
	 * close.
	 *
	 * @param HTML5Element $element to close
	 * @param string $closeAction annimation to perform on close.
	 *  						 Must be a valid \PHPFUI\Animation string.
	 *
	 * @throws \Exception on bad $closeAction
	 */
	public function __construct(\PHPFUI\HTML5Element $element, string $closeAction = '')
		{
		parent::__construct('<span aria-hidden="true">&times;</span>');
		$this->deleteClass('button');
		$this->addClass('close-button');
		$this->addAttribute('aria-label', 'Close');
		$this->addAttribute('data-close');

		if ($closeAction)
			{
			if (! \PHPFUI\Animation::isValid($closeAction))
				{
				throw new \Exception(self::class . ": {$closeAction} is not a valid annimation type");
				}
			}

		if (! $element instanceof \PHPFUI\Reveal)
			{
			$element->addAttribute('data-closable', $closeAction);
			}
		}
	}
