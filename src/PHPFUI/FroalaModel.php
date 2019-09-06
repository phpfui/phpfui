<?php

namespace PHPFUI;

abstract class FroalaModel
	{
	private $events = [];

	private $parameters = [
		'requestWithCORS'                => false,
		'toolbarInline'                  => false,
		'toolbarVisibleWithoutSelection' => true,
		'linkAutoPrefix'                 => '""',
		'spellcheck'                     => true,
		'enter'                          => '$.FroalaEditor.ENTER_BR',
		'fontSize'                       => ['8',
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
																				 '36'],
		'toolbarButtons'                 => [
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
	private $plugins = [
		'colors'          => true,
		'link'            => true,
		'code_view'       => true,
		'code_beautifier' => true,
		'entities'        => true,
		'word_paste'      => true,
		'align'           => true,
		'font_family'     => true,
		'font_size'       => true,
		'lists'           => true,
		'table'           => true,
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

		return this;
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

	}
