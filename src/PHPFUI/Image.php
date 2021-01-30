<?php

namespace PHPFUI;

class Image extends \PHPFUI\HTML5Element
	{
	public function __construct(string $path, string $alt = 'photo')
		{
		parent::__construct('img');
		$this->setAttribute('src', $path);
		$this->setAttribute('alt', $alt);
		}

	public function base64EncodeFile(string $filePath) : Image
		{
		$binaryImage = @\file_get_contents($filePath);

		if (! $binaryImage)
			{
			$this->setAttribute('alt', $filePath . ' not found');
			}

		return $this->base64EncodeString($binaryImage);
		}

	public function base64EncodeString(string $binaryImage) : Image
		{
		$data = \base64_encode($binaryImage);
		$this->setAttribute('src', "data:image/jpeg;base64,{$data}");

		return $this;
		}
	}
