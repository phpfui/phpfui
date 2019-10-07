<?php

echo 'PHPFUI Update: ';

$directory = $argv[1] ?? '';

if (! $directory)
	{
	echo 'You must specify your public directory relative to ' . __DIR__ . ' as a parameter to update.php';
	return;
	}

$directory = __DIR__ . '/' . $directory;
echo "Copying public files into {$directory}\n";

// get submodules
$submodules = [];
$submodules['foundation-datepicker'] = [
	'css/foundation-datepicker.min.css' => 'datepicker/css',
	'js/foundation-datepicker.min.js' => 'datepicker/js',
	'js/locales/*' => 'datepicker/js/locales',
	];
$submodules['JeremyFagis-dropify'] = [
	'dist/css/dropify.min.css' => 'dropify/css',
	'dist/fonts/*' => 'dropify/fonts',
	'dist/js/dropify.min.js' => 'dropify/js',
	];
$submodules['jquery.AreYouSure'] = [
	'jquery.are-you-sure.js' => '',
	];
$submodules['jQuery-Autocomplete'] = [
	'dist/jquery.autocomplete.min.js' => '',
	];
$submodules['kenwheeler-slick'] = [
	'slick/slick.min.js' => 'slick',
	'slick/slick.css' => 'slick',
	'fonts/*' => 'slick/fonts',
	];

copyFiles('submodules', $directory, $submodules);

// get local js files
$js = [];
$js['js'] = [
	'html5sortable.min.js' => '',
	'jquery.arrow_nav.js' => '',
	];

$js['anypicker'] = [
	'anypicker/anypicker-font.css' => 'anypicker',
	'anypicker/anypicker.min.css' => 'anypicker',
	'anypicker/anypicker.min.js' => 'anypicker',
	];

copyFiles('js', $directory, $js);

// get composer files
$vendor = [];
$vendor['zurb/foundation'] = [
	'dist/*' => 'foundation',
	];
$vendor['igorescobar'] = [
	'jquery-mask-plugin/dist/jquery.mask.min.js' => '',
	];
$vendor['froala'] = [
	'wysiwyg-editor/css/*' => 'froala/css',
	'wysiwyg-editor/js/*' => 'froala/js',
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
				echo "Copy: {$source} => {$toPath}\n";
				copy($source, $toPath);
				}
			}
		}
	}


