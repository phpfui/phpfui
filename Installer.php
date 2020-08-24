<?php

namespace PHPFUI;

class Installer
	{

	private $directory;

	public function run(array $argv) : bool
		{
		echo 'PHPFUI Update: ';

		$this->directory = $argv[1] ?? '';

		if (! $this->directory)
			{
			echo 'You must specify your public directory relative to ' . __DIR__ . ' as a parameter to update.php';
			return false;
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

		if (in_array('froala', $argv))
			{
			$vendor['froala/wysiwyg-editor'] = [
				'css/*' => 'froala/css',
				'js/*' => 'froala/js',
				];
			}

		$vendor['components/jquery'] = [
			'jquery.min.js' => '',
			];
		$vendor['fortawesome/font-awesome'] = [
			'css/*.min.css' => 'font-awesome/css',
			'webfonts' => 'font-awesome',
			];

		$this->copyFiles('../..', $vendor);

		// get subtrees
		$subtrees = [];
		$subtrees['najlepsiwebdesigner/foundation-datepicker'] = [
			'css/foundation-datepicker.min.css' => 'datepicker/css',
			'js/foundation-datepicker.min.js' => 'datepicker/js',
			'js/locales/*' => 'datepicker/js/locales',
			];
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
			'html5sortable.min.js' => '',
			'jquery.arrow_nav.js' => '',
			];

		$js['anypicker'] = [
			'fonts' => 'anypicker',
			'i18n' => 'anypicker',
			'anypicker-font.css' => 'anypicker',
			'anypicker.min.css' => 'anypicker',
			'anypicker.min.js' => 'anypicker',
			];

		if (in_array('froala', $argv))
			{
			$js['froala'] = [
			'js' => 'froala',
			];
			}

		$this->copyFiles('js', $js);

		return true;
		}

	public function copyFiles(string $fromDir, array $files) : Installer
		{
		foreach ($files as $sourceDir => $sourceFiles)
			{
			foreach ($sourceFiles as $sourceFile => $copyToPath)
				{
				$sourcePath = __DIR__ . '/' . $fromDir . '/' . $sourceDir . '/' . $sourceFile;
				foreach (glob($sourcePath) as $source)
					{
					$toPath = $this->directory . '/' . $copyToPath;
					$source = str_replace('/', '\\', $source);
					$toPath = str_replace('/', '\\', $toPath);
					@mkdir($toPath, 0777, true);
					$parts = explode('\\', $source);
					$toPath .= '\\' . end($parts);
					// echo "Copy: {$source} => {$toPath}\n";
					if (is_dir($source))
						{
						$this->copyDirectory($source, $toPath);
						}
					else
						{
						copy($source, $toPath);
						}
					}
				}
			}

		return $this;
		}

	public function copyDirectory(string $source, string $dest) : Installer
		{
		if (! file_exists($dest))
			{
			mkdir($dest, 0755, true);
			}
		$iterator = new \RecursiveIteratorIterator(
				new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
				\RecursiveIteratorIterator::SELF_FIRST);
		foreach ($iterator as $item)
			{
			$file = $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
			$file = str_replace('/', '\\', $file);
			if ($item->isDir())
				{
				if (! file_exists($file))
					{
					mkdir($file, 755, true);
					}
				}
			else
				{
				copy($item, $file);
				}
			}

		return $this;
		}
	}
