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
class CSSTest extends \PHPFUI\HTMLUnitTester\Extensions
	{

	public function testValidCSS()
		{
		$this->assertDirectory('ValidCSS', __DIR__ . '/../js');
		$this->assertDirectory('ValidCSS', __DIR__ . '/../subtrees');
		}

	public function testWarningCSS()
		{
		$this->assertDirectory('NotWarningCSS', __DIR__ . '/../js');
		$this->assertDirectory('NotWarningCSS', __DIR__ . '/../subtrees');
		}

	}
