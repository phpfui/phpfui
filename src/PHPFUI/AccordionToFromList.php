<?php

namespace PHPFUI;

class AccordionToFromList extends ToFromList
	{

	public function __construct(Page $page, string $fieldName, array $inGroup, array $notInGroup, string $callbackIndex, callable $callback)
		{
		parent::__construct($page, $fieldName, $inGroup, $notInGroup, $callbackIndex, $callback);
		}

	protected function createWindow(array $groups, string $type) : string
		{
		$output = "<div id='{$this->fieldName}_{$type}' class='ToFromList' ondrop='drop(event,\"{$this->fieldName}\")' ondragover='allowDrop(event)'>";
		$accordion = new Accordion($this->page, 'accordion' . $this->fieldName . $type);
		$accordion->addAttribute('data-multi-expand', 'true');
		$accordion->addAttribute('data-allow-all-closed', 'true');

		foreach ($groups as $tabText => $group)
			{
			$tabContent = '';

			foreach ($group as $line)
				{
				$tabContent .= $this->makeDiv($this->fieldName . '_' . $line[$this->callbackIndex], $type, call_user_func($this->callback, $this->fieldName, $this->callbackIndex, $line, $type));
				}
			$accordion->addTab($tabText, $tabContent);
			}
		$output .= $accordion . '</div>';

		return $output;
		}

	}
