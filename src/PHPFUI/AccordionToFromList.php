<?php

namespace PHPFUI;

/**
 * AccordionToFromList work the same as ToFromList, except the $inGroup and $notInGroup arrays
 * should be indexed by the accordion name you want to display.  Each index will contain arrays
 * conforming to the requirements of ToFromList
 *
 * Currently when items are dragged from one pane to the other, then end up being inserted without a
 * group at the top of the pane.w
 */
class AccordionToFromList extends ToFromList
	{
	public function __construct(Page $page, string $name, array $inGroup, array $notInGroup, string $callbackIndex, callable $callback)
		{
		parent::__construct($page, $name, $inGroup, $notInGroup, $callbackIndex, $callback);
		}

	protected function createWindow(array $groups, string $type) : string
		{
		$output = "<div id='{$this->name}_{$type}' class='ToFromList' ondrop='drop(event,\"{$this->name}\")' ondragover='allowDrop(event)'>";
		$accordion = new Accordion($this->page, 'accordion' . $this->name . $type);
		$accordion->addAttribute('data-multi-expand', 'true');
		$accordion->addAttribute('data-allow-all-closed', 'true');

		foreach ($groups as $tabText => $group)
			{
			$tabContent = '';

			foreach ($group as $line)
				{
				$tabContent .= $this->makeDiv($this->name . '_' . $line[$this->callbackIndex], $type, call_user_func($this->callback, $this->name, $this->callbackIndex, $line[$this->callbackIndex], $type));
				}

			$accordion->addTab($tabText, $tabContent);
			}

		$output .= $accordion . '</div>';

		return $output;
		}
	}
