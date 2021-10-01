<?php

namespace PHPFUI;

class AJAX
	{
	protected $conditions = [];

	protected $name;

	protected $question;

	/**
	 * Set up an AJAX callback
	 *
	 * @param string $name JavaScript function name to be created
	 * @param string $confirmQuestion prompt with this question if set
	 *
	 * The $name is used as the generated function name. Is is also POSTed to the page as the 'action'
	 * parameter.
	 */
	public function __construct(string $name, string $confirmQuestion = '')
		{
		$this->name = $name;
		$this->question = $confirmQuestion;
		}

	/**
	 * Return true if the post is from this AJAX call
	 */
	public function isMyCallback($post) : bool
		{
		return (\PHPFUI\Session::checkCSRF() && ($post['action'] ?? '') == $this->name);
		}

	/**
	 * Add a function parameter and the script that matches the
	 * parameter type according to jQuery.ajax
	 *
	 * @link https://api.jquery.com/jQuery.ajax/#jQuery-ajax-settings
	 */
	public function addFunction(string $function, string $script) : AJAX
		{
		$this->conditions[$function] = $script;

		return $this;
		}

	/**
	 * Return JavaScript that will execute a function call
	 *
	 * @param array $parameters anything you want to pass as data to
	 *  						the AJAX call
	 *
	 * @return string of JavaScript code to be added to the page
	 */
	public function execute(array $parameters) : string
		{
		$js = $this->name . '({';
		$comma = '';

		foreach ($parameters as $key => $value)
			{
			$js .= " {$comma}{$key}:{$value}";
			$comma = ',';
			}

		return $js . '});';
		}

	/**
	 * Get the generated JavaScript function to be added to the
	 * page.
	 *
	 * @return string JavaScript function
	 */
	public function getPageJS() : string
		{
		$csrf = Session::csrf();
		$csrfField = Session::csrfField();
		$js = 'function ' . $this->name . '(data){';
		$extra = '';

		if ($this->question)
			{
			$js .= 'if(window.confirm("' . $this->question . '")){';
			$extra = '}';
			}

		$js .= 'data["' . $csrfField . '"]="' . $csrf . '";data["action"]="' . $this->name . '";$.ajax({dataType:"json",type:"POST",traditional:true,data:data';

		if (empty($this->conditions['error']))
			{
			$this->addFunction('error', 'alert("Error: "+status+", "+arg3);');
			}

		foreach ($this->conditions as $function => $script)
			{
			$js .= ",{$function}:(function(data,status,arg3){ {$script};})";
			}

		$js .= "});{$extra}}";

		return $js;
		}
	}
