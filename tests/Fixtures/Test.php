<?php

namespace Fixtures;

class Test extends \PHPFUI\Page implements \PHPFUI\Interfaces\NanoClass
	{

	public function __construct(\PHPFUI\NanoController $controller)
		{
		parent::__construct($controller);
		}

	public function landingPage()
		{
		$this->add(__METHOD__);
		}

	public function method()
		{
		$this->add(__METHOD__);
		}

	public function arrayMethod(array $data)
		{
		$this->add(__METHOD__);
		$this->add(' Type: ' . gettype($data));
		$this->add(' Value: ' . implode('\\', $data));
		}

	public function intMethod(int $data)
		{
		$this->add(__METHOD__);
		$this->add(' Type: ' . gettype($data));
		$this->add(' Value: ' . $data);
		}

	public function doubleMethod(float $data)
		{
		$this->add(__METHOD__);
		$this->add(' Type: ' . gettype($data));
		$this->add(' Value: ' . $data);
		}

	public function stringMethod(string $data)
		{
		$this->add(__METHOD__);
		$this->add(' Type: ' . gettype($data));
		$this->add(' Value: ' . $data);
		}

	public function boolMethod(bool $data)
		{
		$this->add(__METHOD__);
		$this->add(' Type: ' . gettype($data));
		$this->add(' Value: ' . $data);
		}

	public function classMethod(\Fixtures\Model $data)
		{
		$this->add(__METHOD__);
		$this->add(' Type: ' . get_class($data));
		$this->add(' Value: ' . $data);
		}

	public function multipleMethod(string $s, int $i, float $f, array $a)
		{
		$this->add(__METHOD__);
		$this->add(' Type String: ' . gettype($s));
		$this->add(' Value String: ' . $s);
		$this->add(' Type Integer: ' . gettype($i));
		$this->add(' Value Integer: ' . $i);
		$this->add(' Type Double: ' . gettype($f));
		$this->add(' Value Double: ' . $f);
		$this->add(' Type Array: ' . gettype($a));
		$this->add(' Value Array: ' . implode('\\', $a));
		}

	}

