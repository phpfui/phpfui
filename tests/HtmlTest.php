<?php

/**
 * This file is part of the PHPFUI package
 *
 * (c) Bruce Wells
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source
 * code
 */

error_reporting(E_ALL);

require_once("vendor/autoload.php");

use Kevintweber\PhpunitMarkupValidators\Assert\AssertHtml5;

class HtmlTest extends \PHPUnit\Framework\TestCase
	{

	public function testPage()
		{
		$page = new \PHPFUI\Page();
		AssertHTML5::isValidMarkup($page);
		}

	}