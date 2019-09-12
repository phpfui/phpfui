<?php

namespace PHPFUI;

/**
 * Creates a reveal dialog.  The constructor automatically adds
 * it to the page.  You need to supply a link that will open the
 * reveal.
 */
class Reveal extends HTML5Element
	{

	private $page;

	/**
	 * Construct a reveal dialog. Add items to the reveal dialog
	 * directly. The dialog will automatically be added to the page
	 * and activated when the link is clicked.
	 *
	 * @param HTML5Element $openingElement that user will activate
	 *                           to call up the reveal dialog
	 */
	public function __construct(Page $page, HTML5Element $openingElement)
		{
		parent::__construct('div');
		$this->page = $page;
		$this->addClass('reveal');
		$this->addAttribute('data-reveal');
		$openingElement->addAttribute('data-open', $this->getId());
		$closeButton = new CloseButton($this);
		$this->deleteAttribute('data-closable');
		$this->add($closeButton);
		$page->addReveal($this);
		$dollar = '$';
		$id = $this->getId();
		$page->addJavaScript("{$dollar}('#{$id}').on('open.zf.reveal',function(){{$dollar}('#{$id}').find('input:visible').first().focus();});");
		}

	/**
	 * Closes modal when passed button is pressed
	 *
	 * @param Button $button when pressed will close the modal
	 */
	public function closeOnClick(Button $button) : Reveal
		{
		$button->addAttribute('onclick', '$("#' . $this->getId() . '").foundation("close")');

		return $this;
		}

	/**
	 * Return a button group containing the button passed and a
	 * cancel/close button.
	 *
	 * @param Button $button to be displayed
	 * @param string $cancelText to be shown on the close / cancel
	 *               button
	 */
	public function getButtonAndCancel(Button $button, string $cancelText = 'Cancel') : ButtonGroup
		{
		$ButtonGroup = new ButtonGroup();
		$ButtonGroup->addButton($button);
		$ButtonGroup->addButton($this->getCloseButton($cancelText));

		return $ButtonGroup;
		}

	/**
	 * Returns an button that will close the reveal.
	 *
	 * @param string $text of button
	 */
	public function getCloseButton(string $text = 'Cancel') : Button
		{
		$button = new Button($text);
		$button->addAttribute('aria-label', 'Close')->addAttribute('data-close')->addClass('hollow')->addClass('secondary');

		return $button;
		}

	/**
	 * Show the model immediately on page load
	 */
	public function showOnPageLoad() : Reveal
		{
		$id = $this->getId();
		$this->page->addJavaScript("$('#{$id}').foundation('open');");

		return $this;
		}

	}
