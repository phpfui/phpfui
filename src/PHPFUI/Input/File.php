<?php

namespace PHPFUI\Input;

/**
 * Allow drap and drop handling for input type="name"
 * Use Input('file', ... for traditional upload button
 *
 * @link http://jeremyfagis.github.io/dropify/
 */
class File extends \PHPFUI\Input\Input
	{
	use \PHPFUI\Traits\Page;

	/**
	 * Construct an drag and drop file input field using Dropify
	 *
	 * @param \PHPFUI\Interfaces\Page $page needed to add js and css scrips
	 * @param string $name of input field
	 * @param string $label optional label for use
	 */
	public function __construct(protected \PHPFUI\Interfaces\Page $page, string $name, string $label = '')
		{
		parent::__construct('file', $name, $label, null);
		$this->page->addTailScript('dropify/js/dropify.min.js');
		$this->page->addStyleSheet('dropify/css/dropify.min.css');
		$preventDropJs = <<<JS
var dropZones = [];
function disableNonDropZones(e) {
  if (! dropZones.includes(e.target.id)) {
    e.preventDefault();
    e.dataTransfer.effectAllowed = "none";
    e.dataTransfer.dropEffect = "none";
  }
};
window.addEventListener("dragenter", disableNonDropZones, false);
window.addEventListener("dragover", disableNonDropZones);
window.addEventListener("drop", disableNonDropZones);
JS;
		$this->page->addJavaScript($preventDropJs);

		$js = '$("#' . $this->getId() . '").dropify();dropZones.push("' . $this->getId() . '")';
		$this->page->addJavaScript($js);
		$this->addAttribute('data-height', '100');
		$this->addAttribute('style', 'z-index:0');
		}

	/**
	 * Set allowed extensions. Dropify will validate and open dialog
	 * will be prepopulated with the restriction
	 *
	 * @param array<string> $extensions leading . is optional
	 */
	public function setAllowedExtensions(array $extensions) : static
		{
		foreach ($extensions as &$value)
			{
			$value = \ltrim($value, '.');
			}
		unset($value);

		$this->addAttribute('data-allowed-file-extensions', \implode(' ', $extensions));

		foreach ($extensions as &$value)
			{
			$value = '.' . $value;
			}
		unset($value);

		$this->addAttribute('accept', \implode(',', $extensions));

		return $this;
		}
	}
