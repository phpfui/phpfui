<?php

namespace PHPFUI\Interfaces;

/**
 * Any JavaScript editor you want to integrate needs to
 * implement this interface. When you enable htmlEditing on a
 * text area, your interface class will be called with the
 * current page and the id of the text area to be edited. You
 * will need to do what ever to the page to make the editor
 * work.
 */
interface HTMLEditor
	{
	/**
	 * @param \PHPFUI\Interfaces\Page $page current page
	 * @param string $id of the textarea that ends editing support
	 */
	public function updatePage(\PHPFUI\Interfaces\Page $page, string $id) : void;
	}
