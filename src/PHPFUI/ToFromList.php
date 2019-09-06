<?php

namespace PHPFUI;

class ToFromList extends Base
	{
	protected $callback;
	protected $callbackIndex;
	protected $fieldName;
	protected $inGroup;
	protected $inName = 'In';
	protected $notInGroup;
	protected $outName = 'Out';
	protected $page;

	private static $outputJs = false;

	public function __construct(Page $page, string $fieldName, array $inGroup, array $notInGroup, $callbackIndex, callable $callback)
		{
		parent::__construct();
		$this->page = $page;
		$this->inGroup = $inGroup;
		$this->notInGroup = $notInGroup;
		$this->fieldName = $fieldName;
		$this->callbackIndex = $callbackIndex;
		$this->callback = $callback;

		if (! self::$outputJs)
			{
			self::$outputJs = true;
			$csrf = Session::csrf();
			$csrfField = Session::csrfField();
			$js = 'function allowDrop(e){if(e.preventDefault)e.preventDefault();e.dataTransfer.effectAllowed="move";return true;}' .
				'function move(e,parentid){$("#"+e).remove();' .
				"var params={{$csrfField}:'{$csrf}',action:'getDragDropItem',DraggedId:e,DropParentId:'#'+parentid};" .
				'$.ajax({dataType:"json",traditional:true,data:params,success:function(html){$("#"+parentid).prepend(html.response);}})};' .
				'function dragStart(e){e.dataTransfer.setData("text","#"+e.target.getAttribute("id"));return true;}' .
				'function drop(e,fieldName){e.preventDefault();var draggedid=e.dataTransfer.getData("text");' .
				// could drop on any element in container, keep going up till we have the container
				'var node=e.target;var parentid;' .
				"while(node&&((parentid=node.getAttribute('id'))==null||!(parentid==fieldName+'_in'||parentid==fieldName+'_out'))){node=node.parentNode;}" .
				"if(!node)return false;var params={{$csrfField}:'{$csrf}',action:'getDragDropItem',DraggedId:draggedid,DropParentId:'#'+parentid};" .
				'$.ajax({dataType:"json",traditional:true,data:params,success:function(html){$("#"+parentid).prepend(html.response);}});' .
				'$(draggedid).remove();e.stopPropagation();return true;}';
			$this->page->addJavaScript($js);
			}
		$this->processRequest();
		}

	public function setInName(string $inName) : ToFromList
		{
		$this->inName = $inName;

		return $this;
		}

	public function setOutName(string $outName) : ToFromList
		{
		$this->outName = $outName;

		return $this;
		}

	protected function createWindow(array $group, string $type) : string
		{
		$output = "<div id='{$this->fieldName}_{$type}' class='ToFromList' ondrop='drop(event,\"{$this->fieldName}\")' ondragover='allowDrop(event)'>";

		foreach ($group as $line)
			{
			$output .= $this->makeDiv($this->fieldName . '_' . $line[$this->callbackIndex], $type, call_user_func($this->callback, $this->fieldName, $this->callbackIndex, $line, $type));
			}
		$output .= '</div>';

		return $output;
		}

	protected function getBody() : string
		{
		$row = new GridX();
		$in = new Cell();
		$in->setMedium(6);
		$in->add("<h3>{$this->inName}</h3>");
		$in->add($this->createWindow($this->inGroup, 'in'));
		$row->add($in);
		$out = new Cell();
		$out->setMedium(6);
		$out->add("<h3>{$this->outName}</h3>");
		$out->add($this->createWindow($this->notInGroup, 'out'));
		$row->add($out);

		return "{$row}";
		}

	protected function getEnd() : string
		{
		return '';
		}

	protected function getStart() : string
		{
		return '';
		}

	protected function makeDiv(string $id, string $type, string $html) : string
		{
		$span = new HTML5Element('span');

		if ('in' == $type)
			{
			$span->addAttribute('onclick', 'move("' . $id . '","' . $this->fieldName . '_out")');
			$icon = new Icon('arrow-right');
			$icon->addAttribute('style', 'color:green');
			}
		else
			{
			$span->addAttribute('onclick', 'move("' . $id . '","' . $this->fieldName . '_in")');
			$icon = new Icon('arrow-left');
			$icon->addAttribute('style', 'color:red');
			}
		$span->add($icon);
		$span->add($html);

		return "<div id='{$id}' draggable='true' ondragstart='dragStart(event)' class='draggable'>{$span}</div>";
		}

	private function processRequest() : void
		{
		if (Session::checkCSRF())
			{
			if (isset($_GET['action']))
				{
				switch ($_GET['action'])
					{
					case 'getDragDropItem':
						$dragDropId = trim($_GET['DraggedId'], '#');
						[$fieldName, $id] = explode('_', $dragDropId);

						if ($fieldName == $this->fieldName) // it is us, process
							{
							/** @noinspection PhpUnusedLocalVariableInspection */
							[$junk, $type] = explode('_', $_GET['DropParentId']);
							$html = call_user_func($this->callback, $fieldName, $this->callbackIndex, $id, $type);

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

	}
