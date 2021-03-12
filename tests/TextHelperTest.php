<?php

namespace PHPFUI;

class TextHelperTest extends \PHPUnit\Framework\TestCase
	{
	public function testCapitalSplit() : void
		{
		$this->assertEquals('SQL', TextHelper::capitalSplit('SQL'));
		$this->assertEquals('My SQL', TextHelper::capitalSplit('MySQL'));
		$this->assertEquals('My Class Name', TextHelper::capitalSplit('MyClassName'));
		$this->assertEquals('My Method Name', TextHelper::capitalSplit('myMethodName'));
		$this->assertEquals('One', TextHelper::capitalSplit('one'));
		$this->assertEquals('Two One SQL', TextHelper::capitalSplit('twoOneSQL'));
		$this->assertEquals('Two One SQL Info', TextHelper::capitalSplit('twoOneSQLInfo'));
		$this->assertEquals('SQL Two One SQL Info', TextHelper::capitalSplit('SQLTwoOneSQLInfo'));
		}

	}
