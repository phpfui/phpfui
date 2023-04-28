<?php

namespace PHPFUI;

/**
 * A container to add objects to that will output a fully formed Foundation page.
 */
class Page extends \PHPFUI\VanillaPage implements \PHPFUI\Interfaces\Page
	{
	/** @var array<string, array<string, string>> */
	private array $plugins = [];

	/** @var array<\PHPFUI\Reveal> */
	private array $reveals = [];

	public function __construct()
		{
		parent::__construct();
		$this->setResourcePath('/PHPFUI/');
		$this->addStyleSheet('font-awesome/css/all.min.css');
		$this->setPageName('Created with Foundation');
		$this->addTailScript('jquery.min.js');
		$this->addTailScript('what-input.min.js');
		$this->addTailScript('foundation/js/foundation.min.js');
		$this->addHeadTag('<meta charset="utf-8">');
		$this->addHeadTag('<meta name="viewport" content="width=device-width, initial-scale=1.0">');
		}

	public function addAbideValidator(\PHPFUI\Validator $validator) : static
		{
		$js = $validator->getJavaScript();

		if (! $js)
			{
			return $this;
			}
		$this->addPluginDefault('Abide', "validators['{$validator->getValidatorName()}']", $validator->getFunctionName());

		$this->addJavaScript($js);

		return $this;
		}

	/**
	 * Add copy to clipboard plumbing to the page.  You must still add the $copyOnClick and optional $flashOnCopy to the page in the appropriate locations
	 */
	public function addCopyToClipboard(string $textToCopy, \PHPFUI\HTML5Element $copyOnClick, ?\PHPFUI\HTML5Element $flashOnCopy = null, int $flashMilliSeconds = 2000) : static
		{
		$hidden = new \PHPFUI\Input('text', '', $textToCopy);
		$hidden->addClass('hide');
		$this->add($hidden);

		if ($flashOnCopy)
			{
			$flashOnCopy->addClass('hide');
			$copyOnClick->setAttribute('onclick', 'copyText("' . $hidden->getId() . '","' . $flashOnCopy->getId() . '",' . $flashMilliSeconds . ')');
			$js = 'function copyText(id,callout,delay){$("#"+callout).toggleClass("hide");$("#"+id).toggleClass("hide").select();document.execCommand("copy");$("#"+id).toggleClass("hide");setTimeout(function(){$("#"+callout).toggleClass("hide")},delay);}';
			}
		else
			{
			$copyOnClick->setAttribute('onclick', 'copyTextNoFlash("' . $hidden->getId() . '")');
			$js = 'function copyTextNoFlash(id){$("#"+id).toggleClass("hide").select();document.execCommand("copy");$("#"+id).toggleClass("hide");}';
			}
		$this->addJavaScript($js);

		return $this;
		}

	/**
	 * You can add various plugin default parameters
	 *
	 * Examples:
	 *
	 * $page->addPluginDefault('Abide', 'patterns["zip"]', '/^[0-9-]*$/');
	 * $page->addPluginDefault('Abide', "validators['AutoCompleteRequired']", 'AutoCompleteRequired');
	 */
	public function addPluginDefault(string $pluginName, string $property, string $value) : static
		{
		$this->plugins[$pluginName][$property] = $value;

		return $this;
		}

	/**
	 * Add a reveal dialog to the page
	 *
	 * @param \PHPFUI\Reveal $reveal dialog to store in the page
	 */
	public function addReveal(\PHPFUI\Reveal $reveal) : static
		{
		$this->reveals[] = $reveal;

		return $this;
		}

	protected function getStart() : string
		{
		foreach ($this->reveals as &$reveal)
			{
			$this->add((string)$reveal);
			}

		foreach ($this->plugins as $plugin => $options)
			{
			foreach ($options as $name => $value)
				{
				$this->addJavaScriptFirst("Foundation.{$plugin}.defaults.{$name}={$value};");
				}
			}
		$this->addJavaScriptFirst('$(document).foundation();');

		return parent::getStart();
		}
	}
