<?php

namespace PHPFUI;

class Installer
	{

	private $directory = '';

	private $test = false;

	private $delete = false;

	private $verbose = true;

	public function run(array $argv) : bool
		{
		echo "PHPFUI Update:\n";

		$invalidCount = 0;
		foreach ($argv as $index => $arg)
			{
			if (! $index)
				{
				continue;
				}
			if ('-' === $arg[0])
				{
				$arg .= ' ';
				$option = strtolower($arg[1]);
				switch ($option)
					{
					case 'q':
						$this->verbose = false;
						break;
					case 't':
						$this->test = true;
						break;
					case 'd':
						$this->delete = true;
						break;
					default:
						++$invalidCount;
						break;
					}
				}
			else
				{
				$this->directory = $arg;
				}
			}

		if (! count($argv) || $invalidCount || ! $this->directory)
			{
			echo "\n	Options:\n\n";
			echo "		-t just list the files copied\n";
			echo "		-d delete files in directory before copying\n";
			echo "		-q quiet mode\n\n";
			echo '	You must specify your public directory relative to ' . getcwd() . ' as a parameter';
			exit;
			}

		if ($this->delete && \is_dir($this->directory))
			{
			$this->deleteDirectory($this->directory);
			}

		echo "Copying public files into {$this->directory}\n";

		// get composer files
		$vendor = [];
		$vendor['zurb/foundation'] = [
			'dist/js/foundation.min.js' => 'foundation/js',
			'dist/js/plugins/*.min.js' => 'foundation/js/plugins',
			];
		$vendor['igorescobar/jquery-mask-plugin'] = [
			'dist/jquery.mask.min.js' => '',
			];

		if (is_file('vendor/froala/wysiwyg-editor/composer.json'))
			{
			$vendor['froala/wysiwyg-editor'] = [
				'css/*' => 'froala/css',
				'js/*' => 'froala/js',
				];
			}

		$vendor['components/jquery'] = [
			'jquery.min.js' => '',
			];

		if (is_file('vendor/tinymce/tinymce/composer.json'))
			{
			$vendor['tinymce/tinymce'] = [
				'icons/default/*.js' => 'tinymce/icons/default',
				'models/*' => 'tinymce/models',
				'plugins/*' => 'tinymce/plugins',
				'skins/*' => 'tinymce/skins',
				'themes/*' => 'tinymce/themes',
				'*.min.js' => 'tinymce',
				];
			}

		$vendor['fortawesome/font-awesome'] = [
			'css/*.min.css' => 'font-awesome/css',
			'webfonts' => 'font-awesome',
			];

		$this->copyFiles('../..', $vendor);

		// get subtrees
		$subtrees = [];
		$subtrees['JeremyFagis/dropify'] = [
			'dist/css/dropify.min.css' => 'dropify/css',
			'dist/fonts/*' => 'dropify/fonts',
			'dist/js/dropify.min.js' => 'dropify/js',
			];
		$subtrees['codedance/jquery.AreYouSure'] = [
			'jquery.are-you-sure.js' => '',
			];
		$subtrees['ten1seven/what-input'] = [
			'dist/what-input.min.js' => '',
			];
		$subtrees['devbridge/jQuery-Autocomplete'] = [
			'dist/jquery.autocomplete.min.js' => '',
			'dist/jquery.autocomplete.js' => '',
			];
		$subtrees['kenwheeler/slick'] = [
			'slick/slick.min.js' => 'slick',
			'slick/slick.css' => 'slick',
			'fonts/*' => 'slick/fonts',
			];

		$this->copyFiles('subtrees', $subtrees);

		// get local js files
		$js = [];
		$js['custom'] = [
			'timepicker.js' => '',
			'html5sortable.min.js' => '',
			'jquery.arrow_nav.js' => '',
			];

		if (is_file('vendor/froala/wysiwyg-editor/composer.json'))
			{
			$js['froala'] = [
			'js' => 'froala',
			];
			}

		$this->copyFiles('js', $js);

		// get local css files
		$js = [];
		$js['css'] = [
			'timepicker.css' => 'css',
			];

		$this->copyFiles('', $js);
		return true;
		}

	public function copyFiles(string $fromDir, array $files) : Installer
		{
		if ($fromDir)
			{
			$fromDir .= DIRECTORY_SEPARATOR;
			}
		foreach ($files as $sourceDir => $sourceFiles)
			{
			foreach ($sourceFiles as $sourceFile => $copyToPath)
				{
				$sourcePath = __DIR__ . DIRECTORY_SEPARATOR . $fromDir . $sourceDir . DIRECTORY_SEPARATOR . $sourceFile;
				$sourcePath = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $sourcePath);
				foreach (glob($sourcePath) as $source)
					{
					$toPath = $this->directory . DIRECTORY_SEPARATOR . $copyToPath;
					$source = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $source);
					$toPath = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $toPath);
					if (! $this->test)
						{
						@mkdir($toPath, 0777, true);
						}
					$parts = explode(DIRECTORY_SEPARATOR, $source);
					$toPath .= DIRECTORY_SEPARATOR . end($parts);
					if ($this->verbose)
						{
						echo "Copy: {$source} => {$toPath}\n";
						}
					if (is_dir($source))
						{
						$this->copyDirectory($source, $toPath);
						}
					else
						{
						if (! $this->test)
							{
							copy($source, $toPath);
							}
						}
					}
				}
			}

		return $this;
		}

	public function copyDirectory(string $source, string $dest) : Installer
		{
		if (! file_exists($dest) && ! $this->test)
			{
			mkdir($dest, 0755, true);
			}
		$iterator = new \RecursiveIteratorIterator(
				new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
				\RecursiveIteratorIterator::SELF_FIRST);
		foreach ($iterator as $item)
			{
			$file = $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
			$file = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $file);
			if ($item->isDir())
				{
				if (! file_exists($file) && ! $this->test)
					{
					mkdir($file, 755, true);
					}
				}
			else
				{
				if ($this->verbose)
					{
					echo "Copy: {$item} => {$file}\n";
					}
				if (! $this->test)
					{
					copy($item, $file);
					}
				}
			}

		return $this;
		}

	public function deleteDirectory(string $dest) : int
		{
		$count = 0;
		if (! file_exists($dest))
			{
			return $count;
			}

		echo "Deleting files in {$dest}\n";

		$iterator = new \RecursiveIteratorIterator(
				new \RecursiveDirectoryIterator($dest, \RecursiveDirectoryIterator::SKIP_DOTS),
				\RecursiveIteratorIterator::SELF_FIRST);
		foreach ($iterator as $item)
			{
			if (! $item->isDir())
				{
				$file = $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
				$file = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $file);
				if ($this->verbose)
					{
					echo "Deleting: {$file}\n";
					}
				if (! $this->test)
					{
					unlink($file);
					}
				}
			++$count;
			}

		return $count;
		}
	}
