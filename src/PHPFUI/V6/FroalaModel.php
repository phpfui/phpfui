<?php

namespace PHPFUI\V6;

/**
 * @depreciated Froala is depreciated due to not being completely open source
 *
 * @link https://www.froala.com/wysiwyg-editor
 */
abstract class FroalaModel implements \PHPFUI\Interfaces\HTMLEditor
	{
	private array $events = [];

	private array $parameters = [
		'requestWithCORS' => false,
		'toolbarInline' => false,
		'toolbarVisibleWithoutSelection' => true,
		'linkAutoPrefix' => '""',
		'spellcheck' => true,
		'enter' => '$.FroalaEditor.ENTER_BR',
		'fontSize' => ['8',
			'9',
			'10',
			'11',
			'12',
			'14',
			'16',
			'18',
			'20',
			'24',
			'30',
			'36', ],
		'toolbarButtons' => [
			'"bold"',
			'"italic"',
			'"underline"',
			'"strikeThrough"',
			'"subscript"',
			'"superscript"',
			'"fontFamily"',
			'"fontSize"',
			'"color"',
			'"|"',
			'"insertHR"',
			'"align"',
			'"formatUL"',
			'"formatOL"',
			'"outdent"',
			'"indent"',
			'"insertTable"',
			'"|"',
			'"insertLink"',
			'"selectAll"',
			'"clearFormatting"',
			'"undo"',
			'"redo"',
			'"html"',
		],
	];

	private array $plugins = [
		'colors' => true,
		'link' => true,
		'code_view' => true,
		'code_beautifier' => true,
		'entities' => true,
		'word_paste' => true,
		'align' => true,
		'font_family' => true,
		'font_size' => true,
		'lists' => true,
		'table' => true,
	];

	public function addEventCallback(string $event, array $ajaxParameters) : void
		{
		$this->events[$event] = $ajaxParameters;
		}

	public function addParameter(string $parameter, $value) : FroalaModel
		{
		if (null === $value)
			{
			unset($this->parameters[$parameter]);
			}
		else
			{
			$this->parameters[$parameter] = $value;
			}

		return $this;
		}

	public function addParameters(array $parameters) : FroalaModel
		{
		foreach ($parameters as $parameter => $value)
			{
			$this->parameters[$parameter] = $value;
			}

		return $this;
		}

	public function addPlugin(string $plugin) : FroalaModel
		{
		$this->plugins[$plugin] = true;

		return $this;
		}

	public function addPlugins(array $plugins) : FroalaModel
		{
		foreach ($plugins as $plugin)
			{
			$this->plugins[$plugin] = false;
			}

		return $this;
		}

	public function deleteParameter(string $parameter) : FroalaModel
		{
		unset($this->parameters[$parameter]);

		return $this;
		}

	public function deletePlugin(string $plugin) : FroalaModel
		{
		$this->plugins[$plugin] = false;

		return $this;
		}

	public function getEvents() : array
		{
		return $this->events;
		}

	abstract public function getKey() : string;

	public function getParameters() : array
		{
		return $this->parameters;
		}

	public function getPlugins() : array
		{
		$plugins = [];

		foreach ($this->plugins as $plugin => $active)
			{
			if ($active)
				{
				$plugins[] = $plugin;
				}
			}

		return $plugins;
		}

	public function processPost(array $post) : bool
		{
		return false;
		}

	public function updatePage(\PHPFUI\Interfaces\Page $page, string $id) : void
		{
		foreach ($this->getEvents() as $event => $parameters)
			{
			$function = '(function(e,editor,$param){$.ajax(' . \PHPFUI\TextHelper::arrayToJS($parameters) . ')})';
			$page->addJavaScript('$' . "('#{$id}').on('{$event}',{$function});");
			}

		$page->addJavaScript('$.FroalaEditor.DEFAULTS.key="' . $this->getKey() . '"');
		$page->addJavaScript('$("textarea#' . $id . '").froalaEditor(' . \PHPFUI\TextHelper::arrayToJS($this->getParameters()) . ')');
		$page->addStyleSheet('froala/css/froala_editor.min.css');
		$page->addStyleSheet('froala/css/froala_style.min.css');
		$page->addTailScript('froala/js/froala_editor.min.js');

		foreach ($this->getPlugins() as $plugin)
			{
			$page->addTailScript("froala/js/plugins/{$plugin}.min.js");
			$css = "froala/css/plugins/{$plugin}.min.css";

			if (\file_exists($_SERVER['DOCUMENT_ROOT'] . $page->getResourcePath($css)))
				{
				$page->addStyleSheet($css);
				}
			}
		}
	}
