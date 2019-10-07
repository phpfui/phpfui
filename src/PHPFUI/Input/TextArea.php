<?php

namespace PHPFUI\Input;

/**
 * A text area wrapper with support for WYSIWYG html editing
 * https://www.froala.com/wysiwyg-editor
 */
class TextArea extends Input
	{
	private $rows = 10;

	/**
	 * Construct a TextArea
	 *
	 * @param string $name of field
	 * @param string $label optional
	 * @param ?string $value inital value
	 */
	public function __construct(string $name, string $label = '', ?string $value = '')
		{
		parent::__construct('text', $name);
		$this->value = $value;
		$this->label = $label;
		}

	/**
	 * enable html editing using
	 * https://www.froala.com/wysiwyg-editor
	 *
	 * @param Page $page requires JS
	 *
	 * @return TextArea
	 */
	public function htmlEditing(\PHPFUI\Page $page, \PHPFUI\FroalaModel $model)
		{
		$id = $this->getId();

		foreach ($model->getEvents() as $event => $parameters)
			{
			$function = '(function(e,editor,$param){$.ajax(' . \PHPFUI\TextHelper::arrayToJS($parameters) . ')})';
			$page->addJavaScript('$' . "('#{$id}').on('{$event}',{$function});");
			}

		$page->addJavaScript('$.FroalaEditor.DEFAULTS.key="' . $model->getKey() . '"');
		$page->addJavaScript('$("textarea#' . $id . '").froalaEditor(' . \PHPFUI\TextHelper::arrayToJS($model->getParameters()) . ')');
		$page->addStyleSheet('froala/css/froala_editor.min.css');
		$page->addStyleSheet('froala/css/froala_style.min.css');
		$page->addTailScript('froala/js/froala_editor.min.js');

		foreach ($model->getPlugins() as $plugin)
			{
			$this->addPlugIn($page, $plugin);
			}

		return $this;
		}

	/**
	 * Set the number of rows the text area occupies
	 *
	 * @param int $rows default 10
	 *
	 * @return TextArea
	 */
	public function setRows($rows = 10)
		{
		$this->rows = $rows;

		return $this;
		}

	protected function getEnd() : string
		{
		$output = '</textarea>';

		if (! empty($this->error))
			{
			$output .= "<small class='error'>{$this->error}</small>";
			}

		return $output;
		}

	protected function getStart() : string
		{
		$this->addAttribute('rows', $this->rows);
		$output = $this->getLabel();
		$output .= '<textarea ';
		$output .= $this->getIdAttribute();
		$output .= " name='{$this->name}'";
		$this->deleteAttribute('onkeypress');
		$output .= $this->getAttributes();
		$output .= "{$this->required}>";
		$output .= $this->value;

		return $output;
		}

	private function addPlugIn(\PHPFUI\Page $page, $plugin) : void
		{
		$page->addTailScript("froala/js/plugins/{$plugin}.min.js");
		$css = "froala/css/plugins/{$plugin}.min.css";

		if (file_exists($_SERVER['DOCUMENT_ROOT'] . $page->getResourcePath($css)))
			{
			$page->addStyleSheet($css);
			}
		}
	}
