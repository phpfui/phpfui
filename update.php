<?php

echo 'PHPFUI Update: ';

$directory = $argv[1] ?? '';

if (! $directory)
	{
	echo 'You must specify your public directory relative to ' . __DIR__ . ' as a parameter to update.php';
	return;
	}

$directory = $directory;
echo "Copying public files into {$directory}\n";

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
	];
$subtrees['kenwheeler/slick'] = [
	'slick/slick.min.js' => 'slick',
	'slick/slick.css' => 'slick',
	'fonts/*' => 'slick/fonts',
	];

copyFiles('subtrees', $directory, $subtrees);

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

copyFiles('js', $directory, $js);

// get composer files
$vendor = [];
$vendor['zurb/foundation'] = [
	'dist/js/foundation.min.js' => 'foundation/js',
	'dist/js/plugins/*.min.js' => 'foundation/js/plugins',
	];
$vendor['igorescobar/jquery-mask-plugin'] = [
	'dist/jquery.mask.min.js' => '',
	];
$vendor['froala/wysiwyg-editor'] = [
	'css/*' => 'froala/css',
	'js/*' => 'froala/js',
	];
$vendor['components/jquery'] = [
	'jquery.min.js' => '',
	];

copyFiles('vendor', $directory, $vendor);

function copyFiles(string $fromDir, string $toDir, array $files)
	{
	foreach ($files as $sourceDir => $sourceFiles)
		{
		foreach ($sourceFiles as $sourceFile => $copyToPath)
			{
			$sourcePath = __DIR__ . '/' . $fromDir . '/' . $sourceDir . '/' . $sourceFile;
			foreach (glob($sourcePath) as $source)
				{
				$toPath = $toDir . '/' . $copyToPath;
				$source = str_replace('/', '\\', $source);
				$toPath = str_replace('/', '\\', $toPath);
				@mkdir($toPath, 0777, true);
				$parts = explode('\\', $source);
				$toPath .= '\\' . end($parts);
				// echo "Copy: {$source} => {$toPath}\n";
				if (is_dir($source))
					{
					copyDirectory($source, $toPath);
					}
				else
					{
					copy($source, $toPath);
					}
				}
			}
		}
	}

function copyDirectory(string $source, string $dest)
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
	}

