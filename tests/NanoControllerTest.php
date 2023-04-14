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
class NanoControllerTest extends \PHPUnit\Framework\TestCase
	{
	public function setUp() : void
	 {
	 $page = new \PHPFUI\Page();
	 $page->setDebug(0);
	 }

	public function testMissing() : void
		{
		$controller = new \PHPFUI\NanoController($uri = '/Random/url');
		$controller->setMissingMethod('landingPage');
		$controller->setRootNamespace('Fixtures');
		$controller->setMissingClass(\Fixtures\Missing::class);
		$class = $controller->run();
		$this->assertEquals(\Fixtures\Missing::class, \get_class($class), 'Missing class not returned for ' . $uri);
		}

	public function testLanding() : void
		{
		$controller = new \PHPFUI\NanoController('/Test');
		$controller->setMissingMethod('landingPage');
		$controller->setRootNamespace('Fixtures');
		$controller->setMissingClass(\Fixtures\Missing::class);
		$class = $controller->run();
		$this->assertStringContainsString('::landingPage', "{$class}", 'Landing page not found');
		}

	public function testMethod() : void
		{
		$controller = new \PHPFUI\NanoController('/Test/method');
		$controller->setMissingMethod('landingPage');
		$controller->setRootNamespace('Fixtures');
		$controller->setMissingClass(\Fixtures\Missing::class);
		$class = $controller->run();
		$this->assertStringContainsString('::method', "{$class}", 'method not found');
		}

	public function testMethodArray() : void
		{
		$controller = new \PHPFUI\NanoController('/Test/arrayMethod/1/2/3/a/b/c');
		$controller->setMissingMethod('landingPage');
		$controller->setRootNamespace('Fixtures');
		$controller->setMissingClass(\Fixtures\Missing::class);
		$class = $controller->run();
		$this->assertStringContainsString('::arrayMethod', "{$class}", 'arrayMethod not found');
		$this->assertStringContainsString('Type: array', "{$class}", 'type array not found');
		$this->assertStringContainsString('Value: 1\2\3\a\b\c', "{$class}", 'Array not found');
		}

	public function testMethodInt() : void
		{
		$controller = new \PHPFUI\NanoController('/Test/intMethod/123');
		$controller->setMissingMethod('landingPage');
		$controller->setRootNamespace('Fixtures');
		$controller->setMissingClass(\Fixtures\Missing::class);
		$class = $controller->run();
		$this->assertStringContainsString('::intMethod', "{$class}", 'intMethod not found');
		$this->assertStringContainsString('Type: integer', "{$class}", 'type integer not found');
		$this->assertStringContainsString('Value: 123', "{$class}", 'Int value not found');
		}

	public function testMethodIntBadCast() : void
		{
		$controller = new \PHPFUI\NanoController('/Test/intMethod/sdfsadf');
		$controller->setMissingMethod('landingPage');
		$controller->setRootNamespace('Fixtures');
		$controller->setMissingClass(\Fixtures\Missing::class);
		$class = $controller->run();
		$this->assertStringContainsString('::intMethod', "{$class}", 'intMethod not found');
		$this->assertStringContainsString('Type: integer', "{$class}", 'type bad cast integer not found');
		$this->assertStringContainsString('Value: 0', "{$class}", 'Int bad cast value not found');
		}

	public function testMethodBool() : void
		{
		$controller = new \PHPFUI\NanoController('/Test/boolMethod/1');
		$controller->setMissingMethod('landingPage');
		$controller->setRootNamespace('Fixtures');
		$controller->setMissingClass(\Fixtures\Missing::class);
		$class = $controller->run();
		$this->assertStringContainsString('::boolMethod', "{$class}", 'boolMethod not found');
		$this->assertStringContainsString('Type: boolean', "{$class}", 'type boolean not found');
		$this->assertStringContainsString('Value: 1', "{$class}", 'bool value not found');
		}

	public function testMethodBoolBadCast() : void
		{
		$controller = new \PHPFUI\NanoController('/Test/boolMethod/10');
		$controller->setMissingMethod('landingPage');
		$controller->setRootNamespace('Fixtures');
		$controller->setMissingClass(\Fixtures\Missing::class);
		$class = $controller->run();
		$this->assertStringContainsString('::boolMethod', "{$class}", 'boolMethod not found');
		$this->assertStringContainsString('Type: boolean', "{$class}", 'type bad cast boolean not found');
		$this->assertStringContainsString('Value: 1', "{$class}", 'bool bad cast value not found');
		}

	public function testMethodDouble() : void
		{
		$controller = new \PHPFUI\NanoController('/Test/doubleMethod/1.23');
		$controller->setMissingMethod('landingPage');
		$controller->setRootNamespace('Fixtures');
		$controller->setMissingClass(\Fixtures\Missing::class);
		$class = $controller->run();
		$this->assertStringContainsString('::doubleMethod', "{$class}", 'doubleMethod not found');
		$this->assertStringContainsString('Type: double', "{$class}", 'type double not found');
		$this->assertStringContainsString('Value: 1.23', "{$class}", 'double value not found');
		}

	public function testMethodString() : void
		{
		$controller = new \PHPFUI\NanoController('/Test/stringMethod/qwerty');
		$controller->setMissingMethod('landingPage');
		$controller->setRootNamespace('Fixtures');
		$controller->setMissingClass(\Fixtures\Missing::class);
		$class = $controller->run();
		$this->assertStringContainsString('::stringMethod', "{$class}", 'stringMethod not found');
		$this->assertStringContainsString('Type: string', "{$class}", 'type string not found');
		$this->assertStringContainsString('Value: qwerty', "{$class}", 'string value not found');
		}

	public function testMethodClass() : void
		{
		$controller = new \PHPFUI\NanoController('/Test/classMethod/qwerty');
		$controller->setMissingMethod('landingPage');
		$controller->setRootNamespace('Fixtures');
		$controller->setMissingClass(\Fixtures\Missing::class);
		$class = $controller->run();
		$this->assertStringContainsString('::classMethod', "{$class}", 'classMethod not found');
		$this->assertStringContainsString('Type: Fixtures\Model', "{$class}", 'type Fixtures\Model not found');
		$this->assertStringContainsString('Value: <div>qwerty</div>', "{$class}", 'class value not found');
		}

	public function testMethodMultiple() : void
		{
		$controller = new \PHPFUI\NanoController('/Test/multipleMethod/qwerty/10/1.23/a/b/c');
		$controller->setMissingMethod('landingPage');
		$controller->setRootNamespace('Fixtures');
		$controller->setMissingClass(\Fixtures\Missing::class);
		$class = $controller->run();
		$this->assertStringContainsString('::multipleMethod', "{$class}", 'multipleMethod not found');
		$this->assertStringContainsString('Type String: string', "{$class}", 'multiple type string not found');
		$this->assertStringContainsString('Type Integer: integer', "{$class}", 'multiple type integer not found');
		$this->assertStringContainsString('Type Double: double', "{$class}", 'multiple type double not found');
		$this->assertStringContainsString('Type Array: array', "{$class}", 'multiple type array not found');
		$this->assertStringContainsString('Value String: qwerty', "{$class}", 'multiple string value not found');
		$this->assertStringContainsString('Value Integer: 10', "{$class}", 'multiple integer value not found');
		$this->assertStringContainsString('Value Double: 1.23', "{$class}", 'multiple double value not found');
		$this->assertStringContainsString('Value Array: a\b\c', "{$class}", 'multiple array value not found');
		}
	}
