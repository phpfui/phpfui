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

	protected $page;

	/**
	 * Construct an drag and drop file input field using Dropify
	 *
	 * @param Page $page needed to add js and css scrips
	 * @param string $name of input field
	 * @param string $label optional label for use
	 */
	public function __construct(\PHPFUI\Interfaces\Page $page, string $name, string $label = '')
		{
		parent::__construct('file', $name, $label, null);
		$this->page = $page;
		$this->page->addTailScript('dropify/js/dropify.min.js');
		$this->page->addStyleSheet('dropify/css/dropify.min.css');
		$js = '$("#' . $this->getId() . '").dropify()';
		$this->page->addJavaScript($js);
		$this->addAttribute('data-height', 100);
		$this->addAttribute('style', 'z-index:0');
		}

	/**
	 * Set allowed extensions. Dropify will validate and open dialog
	 * will be prepopulated with the restriction
	 *
	 * @param array $extensions leading . is optional
	 */
	public function setAllowedExtensions(array $extensions) : File
		{
		foreach ($extensions as &$value)
			{
			$value = ltrim($value, '.');
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
