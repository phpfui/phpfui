<?php

namespace PHPFUI\Interfaces;

interface NanoController
	{
	public function getErrors() : array;

	public function getFiles() : array;

	public function getGet() : array;

	public function getInvokedPath() : string;

	public function getPost() : array;

	public function getUri() : string;

	public function run() : \PHPFUI\Interfaces\NanoClass;

	public function setFiles(array $files) : self;

	public function setGet(array $get) : self;

	public function setMissingClass(string $missingClass) : self;

	public function setMissingMethod(string $missingMethod) : self;

	public function setPost(array $post) : self;

	public function setRootNamespace(string $namespace) : self;
	}
