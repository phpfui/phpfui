<?php

namespace PHPFUI;

class ToFromList extends \PHPFUI\Base
	{
	use \PHPFUI\Traits\Page;

	protected \PHPFUI\Container $inIcon;

	protected string $inName = 'In';

	protected \PHPFUI\Container $outIcon;

	protected string $outName = 'Out';

	protected bool $readOnly = false;

	private static bool $outputJs = false;

	/**
	 * The ToFromList implements a two side by side panes that uses can drag and drop from one side to
	 * the other.  It does not support ordering within panes. It assumes you are picking data from a
	 * master list and putting each item in to one group or the other.
	 *
	 * **The data:**
	 *
	 * The ToFromList assumes you have one master array with numeric indexes from 0 to what ever. Each
	 * item in the master array must be an array and have an index specified by $callbackIndex. It will
	 * be the record number of itself in the master array.  This is needed because we can not use the
	 * array index from the $inGroup or $notInGroup, as those are subsets of the master array. So each
	 * element in the master array must keep track of it's own index in the master array. You can
	 * include any other data in this array you want, but it is recommend you have a human readable
	 * name, or a way to get this, as you will need to return that in the callback function.
	 *
	 * **The callback:**
	 *
	 * The callback should have the following signature:
	 *
	 * ```
	 * function (string $fieldName, string $index, mixed $userData, string $type) : string
	 * ```
	 *
	 * @param \PHPFUI\Interfaces\Page $page needed for JavaScript
	 * @param string $name identifying this ToFromList from others on the same page.  Needs to be
	 *  		 unique per page
	 * @param array<int, array<string, string>> $inGroup data for the selected group.  See below for array requirements.
	 * @param array<int, array<string, string>> $notInGroup data for the unselected group.  See below for array requirements.
	 * @param string $callbackIndex is used to identify records by index in your master set of data.
	 * @param callable $callback used to format the text used to drag and drop.
	 */
	public function __construct(protected \PHPFUI\Interfaces\Page $page, protected string $name, protected array $inGroup, protected array $notInGroup, protected string $callbackIndex, protected $callback)
		{
		parent::__construct();

		$this->inIcon = new \PHPFUI\Container();
		$rightIcon = new \PHPFUI\Icon('arrow-right');
		$rightIcon->addAttribute('style', 'color:green');
		$rightIcon->addClass('show-for-medium');
		$this->inIcon->add($rightIcon);
		$downIcon = new \PHPFUI\Icon('arrow-down');
		$downIcon->addAttribute('style', 'color:green');
		$downIcon->addClass('show-for-small-only');
		$this->inIcon->add($downIcon);

		$this->outIcon = new \PHPFUI\Container();
		$leftIcon = new \PHPFUI\Icon('arrow-left');
		$leftIcon->addAttribute('style', 'color:red');
		$leftIcon->addClass('show-for-medium');
		$this->outIcon->add($leftIcon);
		$upIcon = new \PHPFUI\Icon('arrow-up');
		$upIcon->addAttribute('style', 'color:red');
		$upIcon->addClass('show-for-small-only');
		$this->outIcon->add($upIcon);

		$this->processRequest();
		}

	/**
	 * You can customize the "in" icon (or remove it) by passing in html
	 *
	 * @param mixed $inIcon should convert to valid html string
	 */
	public function setInIcon(mixed $inIcon) : static
		{
		$this->inIcon = $inIcon;

		return $this;
		}

	/**
	 * Sets the header name for the "in" group
	 */
	public function setInName(string $inName) : static
		{
		$this->inName = $inName;

		return $this;
		}

	/**
	 * You can customize the "out" icon (or remove it) by passing in html
	 *
	 * @param mixed $outIcon should convert to valid html string
	 */
	public function setOutIcon(mixed $outIcon) : static
		{
		$this->outIcon = $outIcon;

		return $this;
		}

	/**
	 * Sets the header name for the "out" group
	 */
	public function setOutName(string $outName) : static
		{
		$this->outName = $outName;

		return $this;
		}

	public function setReadOnly() : static
		{
		$this->readOnly = true;

		return $this;
		}

	/** @param array<array<string>> $group */
	protected function createWindow(array $group, string $type) : string
		{
		if (! $this->readOnly)
			{
			$output = "<div id='{$this->name}_{$type}' class='ToFromList' ondrop='dropToFromList(event,\"{$this->name}\")' ondragover='allowDropToFromList(event)'>";
			}
		else
			{
			$output = "<div id='{$this->name}_{$type}' class='ToFromList'>";
			}

		foreach ($group as $line)
			{
			$output .= $this->makeDiv($this->name . '_' . $line[$this->callbackIndex], $type, \call_user_func($this->callback, $this->name, $this->callbackIndex, $line[$this->callbackIndex], $type));
			}

		$output .= '</div>';

		return $output;
		}

	protected function getBody() : string
		{
		$row = new \PHPFUI\GridX();
		$in = new \PHPFUI\Cell();
		$in->setMedium(6);
		$in->add("<h3>{$this->inName}</h3>");
		$in->add($this->createWindow($this->inGroup, 'in'));
		$row->add($in);
		$out = new \PHPFUI\Cell();
		$out->setMedium(6);
		$out->add("<h3>{$this->outName}</h3>");
		$out->add($this->createWindow($this->notInGroup, 'out'));
		$row->add($out);

		return (string)$row;
		}

	protected function getEnd() : string
		{
		return '';
		}

	protected function getStart() : string
		{
		if (! self::$outputJs)
			{
			self::$outputJs = true;
			$csrf = \PHPFUI\Session::csrf();
			$csrfField = \PHPFUI\Session::csrfField();
			$js = 'function allowDropToFromList(e){if(e.preventDefault)e.preventDefault();e.dataTransfer.effectAllowed="move";return true;}' .
		'function moveToFromList(e,parentid){$("#"+e).remove();' .
		"var params={{$csrfField}:'{$csrf}',action:'getDragDropItem',DraggedId:e,DropParentId:'#'+parentid};" .
		'$.ajax({dataType:"json",traditional:true,data:params,success:function(html){$("#"+parentid).prepend(html.response);}})};' .
		'function dragStartToFromList(e){e.dataTransfer.setData("text","#"+e.target.getAttribute("id"));return true;}' .
		'function dropToFromList(e,fieldName){e.preventDefault();var draggedid=e.dataTransfer.getData("text");' .
		// could drop on any element in container, keep going up till we have the container
		'var node=e.target;var parentid;' .
		"while(node&&((parentid=node.getAttribute('id'))==null||!(parentid==fieldName+'_in'||parentid==fieldName+'_out'))){node=node.parentNode;}" .
		"if(!node)return false;var params={{$csrfField}:'{$csrf}',action:'getDragDropItem',DraggedId:draggedid,DropParentId:'#'+parentid};" .
		'$.ajax({dataType:"json",traditional:true,data:params,success:function(html){$("#"+parentid).prepend(html.response);}});' .
		'$(draggedid).remove();e.stopPropagation();return true;}';
			$this->page->addJavaScript($js);
			}

		return '';
		}

	protected function makeDiv(string $id, string $type, string $html) : string
		{
		$span = new \PHPFUI\HTML5Element('span');

		if ('in' == $type)
			{
			if (! $this->readOnly)
				{
				$span->addAttribute('onclick', 'moveToFromList("' . $id . '","' . $this->name . '_out")');
				}
			$icon = $this->inIcon;
			}
		else
			{
			if (! $this->readOnly)
				{
				$span->addAttribute('onclick', 'moveToFromList("' . $id . '","' . $this->name . '_in")');
				}
			$icon = $this->outIcon;
			}

		$span->add($icon);
		$span->add($html);

		if (! $this->readOnly)
			{
			return "<div id='{$id}' draggable='true' ondragstart='dragStartToFromList(event)' class='draggable'>{$span}</div>";
			}

		return "<div id='{$id}'>{$span}</div>";
		}

	private function processRequest() : void
		{
		if (! $this->readOnly && \PHPFUI\Session::checkCSRF() && isset($_GET['action']))
			{
			switch ($_GET['action'])
					{
					case 'getDragDropItem':

						$dragDropId = \trim($_GET['DraggedId'], '#');
						[$name, $id] = \explode('_', $dragDropId);

						if ($name == $this->name)
							{ // it is us, process

							/** @noinspection PhpUnusedLocalVariableInspection */
							[$junk, $type] = \explode('_', $_GET['DropParentId']);
							$html = \call_user_func($this->callback, $name, $this->callbackIndex, $id, $type);

							if ($html)
								{
								$this->page->setResponse($this->makeDiv($dragDropId, $type, $html));
								}
							}

						break;

					}
			}
		}
	}
