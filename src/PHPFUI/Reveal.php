<?php

namespace PHPFUI;

/**
 * Creates a reveal dialog.  The constructor automatically adds
 * it to the page.  You need to supply a link that will open the
 * reveal.
 */
class Reveal extends \PHPFUI\HTML5Element
	{
	private \PHPFUI\Interfaces\Page $page;

	/**
	 * Construct a reveal dialog. Add items to the reveal dialog
	 * directly. The dialog will automatically be added to the page
	 * and activated when the link is clicked.
	 *
	 * @param HTML5Element $openingElement that user will activate
	 *                           to call up the reveal dialog
	 */
	public function __construct(\PHPFUI\Interfaces\Page $page, HTML5Element $openingElement)
		{
		parent::__construct('div');
		$this->page = $page;
		$this->addClass('reveal');
		$this->addAttribute('data-reveal');
		$openingElement->addAttribute('data-open', $this->getId());
		$closeButton = new \PHPFUI\CloseButton($this);
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
	public function closeOnClick(\PHPFUI\Button $button) : Reveal
		{
		$button->addAttribute('onclick', '$("#' . $this->getId() . '").on("formvalid.zf.abide",function(ev,frm){$("#' . $this->getId() . '").foundation("close")})');

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
	public function getButtonAndCancel(\PHPFUI\Button $button, string $cancelText = 'Cancel') : ButtonGroup
		{
		$ButtonGroup = new \PHPFUI\ButtonGroup();
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
		$button = new \PHPFUI\Button($text);
		$button->addAttribute('aria-label', 'Close')->addAttribute('data-close')->addClass('hollow')->addClass('secondary');

		return $button;
		}

	/**
	 * Load URL on open to populate Reveal
	 *
	 * @param string $url to load
	 * @param string $targetId is optional area to load html into, default is entire Reveal window
	 */
	public function loadUrlOnOpen(string $url, string $targetId = '') : Reveal
		{
		$id = $this->getId();

		if (! $targetId)
			{
			$targetId = $id;
			}

		$this->page->addJavaScript('$(\'#' . $id . '\').on("open.zf.reveal", function(){$.ajax(\'' . $url . '\').done(function(resp){$(\'#' . $targetId . '\').html(resp)})})');

		return $this;
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

	protected function getStart() : string
		{
		// call inReveal for any object that needs to know it is in a Reveal (autocomplete stuff for now).
		$this->walk('inReveal', true);

		return parent::getStart();
		}
	}
