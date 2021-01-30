<?php

namespace PHPFUI;

/**
 * Update a cell on a timer
 */
class TimedCellUpdate extends \PHPFUI\Base
	{
	protected $callback;

	protected $callbackId;

	private static $callbackNumber = 0;

	/**
	 * Construct a TimedCellUpdate.  The cell will be updated with
	 * the supplied call back and the timeout interval specified
	 *
	 * @param Page $page as we need to add JS
	 * @param string $callbackId the id of the element to update
	 * @param callable $callback PHP callback that will be called
	 *                             every timeout interval. Should return the new
	 *  													 contents of the cell. It is passed the id of the field being updated.
	 * @param int $timeoutSeconds interval to be called back, default 30 seconds
	 * @param string $offString if the callback returns this string, the timer will be turned off.
	 *  						 Default is blank, so if the callback returns blank, the timer is turned off.
	 */
	public function __construct(\PHPFUI\Interfaces\Page $page, string $callbackId, callable $callback, int $timeoutSeconds = 30, string $offString = '')
		{
		parent::__construct();
		$this->callbackId = $callbackId;
		$this->callback = $callback;
		$cbn = \str_replace('\\', '', __CLASS__ . (++self::$callbackNumber));
		$timeoutSeconds *= 1000;
		$csrf = Session::csrf();
		$csrfField = Session::csrfField();
		$dollar = '$';
		$js = "var startTimer=function(){var timerId=setInterval(function(){{$dollar}.ajax({dataType:'json',type:'POST',traditional:true,data:{{$csrfField}:'{$csrf}',id:'{$callbackId}',callback:'{$cbn}'},success:function(data){{$dollar}('#{$callbackId}').html(data.response);if(data.response=='{$offString}'){clearInterval(timerId);}}})},{$timeoutSeconds})};startTimer();";
		$page->addJavaScript($js);

		if (isset($_POST['callback']) && $_POST['callback'] == $cbn && $_POST[$csrfField] == $csrf && $callbackId == $_POST['id'])
			{
			$page->setResponse("{$this}");
			}
		}

	protected function getBody() : string
		{
		return \call_user_func($this->callback, $this->callbackId);
		}

	protected function getEnd() : string
		{
		return '';
		}

	protected function getStart() : string
		{
		return '';
		}
	}
