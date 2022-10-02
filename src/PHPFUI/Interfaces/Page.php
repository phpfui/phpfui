<?php

namespace PHPFUI\Interfaces;

/**
 * Basic Page interface
 */
interface Page
	{
	/**
	 * Add dedupped inline css
	 */
	public function addCSS(string $css) : self;

	/**
	 * Add dedupped JavaScript to the header
	 */
	public function addHeadJavaScript(string $js) : self;

	/**
	 * Add a dedupped header script
	 *
	 * @param string $module path to script
	 */
	public function addHeadScript(string $module) : self;

	/**
	 * Add a meta tag to the head section of the page
	 */
	public function addHeadTag(string $tag) : self;

	/**
	 * Add IE commands.  For example you should restrict IE 8 and lower clients.
	 *
	 * ```
	 * $page->addIEComments('<!--[if lt IE9]><script>window.location="/old/index.html";</script><![endif]-->');
	 * ```
	 */
	public function addIEComments(string $comment) : self;

	/**
	 * Add dedupped JavaScript to the page
	 */
	public function addJavaScript(string $js) : self;

	/**
	 * Add dedupped JavaScript as the first JavaScript before Foundation
	 */
	public function addJavaScriptFirst(string $js) : self;

	/**
	 * Add dedupped JavaScript as the last JavaScript on the page
	 */
	public function addJavaScriptLast(string $js) : self;

	/**
	 * Add dedupped Style Sheet to the page
	 *
	 * @param string $module filename
	 */
	public function addStyleSheet(string $module) : self;

	/**
	 * Add a dedupped script to the end of the page
	 *
	 * @param string $module path to script
	 */
	public function addTailScript(string $module) : self;

	/**
	 * Return just the base URI without the query string
	 */
	public function getBaseURL() : string;

	/**
	 * Return the Fav Icon
	 */
	public function getFavIcon() : string;

	/**
	 * Return the current page name
	 */
	public function getPageName() : string;

	/**
	 * Returns array of the current query parameters
	 *
	 * @return array<string, string>
	 */
	public function getQueryParameters() : array;

	/**
	 * Get fully qualified resource path root relative with resource if passed
	 *
	 * A $resource starting with / or http is not modified
	 */
	public function getResourcePath(string $resource = '') : string;

	/**
	 * return true if it has a built in date picker detectable by  HTTP_USER_AGENT
	 */
	public function hasDatePicker() : bool;

	/**
	 * return true if it has a built in date time picker detectable by HTTP_USER_AGENT
	 */
	public function hasDateTimePicker() : bool;

	/**
	 * return true if it has a built in time picker detectable by HTTP_USER_AGENT
	 */
	public function hasTimePicker() : bool;

	/**
	 * Return true if Android platform
	 */
	public function isAndroid() : bool;

	/**
	 * Return true if Chrome browser
	 */
	public function isChrome() : bool;

	/**
	 * Return true if Windows Mobile browser
	 */
	public function isIEMobile() : bool;

	/**
	 * Return true if IOS platform
	 */
	public function isIOS() : bool;

	/**
	 * Redirect page.  Default will redirect to the current page
	 * minus query string.  Pass formatted query string as
	 * $parameter with no leading ?.
	 *
	 * @param string $url default '', current url
	 * @param string $parameters default ''
	 * @param int $timeout default 0
	 */
	public function redirect(string $url = '', string $parameters = '', int $timeout = 0) : self;

	/**
	 * Sets the Fav Icon (shown in browser tabs and elsewhere in the
	 * browser)
	 *
	 * @param string $path to favicon
	 */
	public function setFavIcon(string $path) : self;

	/**
	 * Set the page language
	 */
	public function setLanguage(string $lang) : self;

	/**
	 * Set the page name.  Defaults to "Created with Foundation"
	 *
	 * @param string $name of page
	 */
	public function setPageName(string $name) : self;

	/**
	 * $resoursePath should start from the public root directory and include a trailing forward slash
	 */
	public function setResourcePath(string $resoursePath = '/') : self;

	/**
	 * Set a response in the standard format ('reponse' and 'color' array)
	 *
	 * @param string $response to return
	 * @param string $color used for the save button
	 */
	public function setResponse(string $response, string $color = 'lime') : static;

	/**
	 * Sets the page response directly
	 */
	public function setRawResponse(string $response, bool $asJSON = true) : static;

	/**
	 * Returns true if the page needs no more processing
	 */
	public function isDone() : bool;
	}
