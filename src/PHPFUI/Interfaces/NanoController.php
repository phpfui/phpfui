<?php

namespace PHPFUI\Interfaces;

interface NanoController
	{
	/** @return array<string> */
	public function getErrors() : array;

	/** @return array<string, array<string, string>> */
	public function getFiles() : array;

	/** @return array<string, string> */
	public function getGet() : array;

	public function getInvokedPath() : string;

	/** @return array<string, string> */
	public function getPost() : array;

	public function getUri() : string;

	public function run() : \PHPFUI\Interfaces\NanoClass;

	/** @param array<string, array<string, string>> $files */
	public function setFiles(array $files) : static;

	/** @param array<string, string> $get */
	public function setGet(array $get) : static;

	public function setMissingClass(string $missingClass) : static;

	public function setMissingMethod(string $missingMethod) : static;

	/** @param array<string, string> $post */
	public function setPost(array $post) : static;

	public function setRootNamespace(string $namespace) : static;
	}
