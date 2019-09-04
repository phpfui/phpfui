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

require_once("bootstrap.php");

use Kevintweber\PhpunitMarkupValidators\Assert\AssertHtml5;

class HtmlTest extends \PHPUnit\Framework\TestCase
  {

  public function testPage()
    {
    AssertHTML5::isValidMarkup(new \PHPFUI\Page());
    }

  }