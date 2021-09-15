# PHPFUI [![Build Status](https://api.travis-ci.com/phpfui/phpfui.png?branch=master)](https://api.travis-ci.com/phpfui/phpfui) [![Latest Packagist release](https://img.shields.io/packagist/v/phpfui/phpfui.svg)](https://packagist.org/packages/phpfui/phpfui)

PHP Wrapper for the Foundation CSS Framework

**PHPFUI**, **PHP** **F**oundation **U**ser **I**nterface, is a [modern](#php-versions) PHP library that produces HTML formated for [Foundation](https://get.foundation/sites/docs/).  It does everything you need for a fully functional Foundation page, with the power of an OO language. It currently uses Foundation 6.6.

> "I was surprised that people were prepared to write HTML. In my initial requirements for this thing, I had assumed, as an absolute pre-condition, that nobody would have to do HTML or deal with URLs. If you use the original World Wide Web program, you never see a URL or have to deal with HTML. You're presented with the raw information. You then input more information. So you are linking information to information--like using a word processor. That was a surprise to me--that people were prepared to painstakingly write HTML."

[Sir Tim Berners-Lee, inventor of the World Wide Web](http://web.archive.org/web/20050831085206/http://www.w3journal.com/3/s1.interview.html)

Using PHPFUI for view output will produce 100% valid HTML and insulate you from future changes to Foundation, your custom HMTL layouts, CSS and JS library changes. You write to an abstract concept (I want a checkbox here), and the library will output a checkbox formatted for Foundation. You can inherit from CheckBox and add your own take on a checkbox, and when the graphic designer decides they have the most awesome checkbox ever, you simply change your CheckBox class, and it is changed on every page system wide.

Don't write HTML by hand!

## Usage
```PHP
namespace PHPFUI;
$page = new Page();
$form = new Form($page);
$fieldset = new FieldSet('A basic input form');
$time = new Input\Time($page, 'time', 'Enter A Time in 15 minute increments');
$time->setRequired();
$date = new Input\Date($page, 'date', 'Pick A Date');
$fieldset->add(new MultiColumn($time, $date));
$fieldset->add(new Input\TextArea('text', 'Enter some text'));
$fieldset->add(new Submit());
$form->add($fieldset);
$page->add($form);
$page->addStyleSheet('/css/styles.css');
echo $page;
```

## Installation Instructions

~~~
composer require phpfui/phpfui
~~~

Then run **update.php** from the vendor/phpfui/phpfui directory and supply the path to your public directory / the directory for the various JS and CSS files PHPFUI uses. This will copy all required public files into your public directory. For example:

~~~
php vendor/phpfui/phpfui/update.php public/PHPFUI
~~~

The PHPFUI library defaults to your-public-directory/PHPFUI, it can be overridden, but it is suggested to use PHPFUI to keep everything in one place. **update.php** should be run when ever you update PHPFUI.

## Versioning
Versioning will match the [Foundation versions](https://github.com/foundation/foundation-sites/releases) for Major semantic versions. PHPUI will always support the most recent version of Foundation possible for the Major version. PHPFUI Minor version will include breaking changes and may incorporate changes for the latest version of Foundation. The PHPFUI Patch version will include non breaking changes or additions.  So PHPFUI Version 6.0.0 would be the first version of the library, 6.0.1 would be the first patch of PHPFUI. Both should work with any Foundation 6.x version.  PHPFUI 6.1.0 would be a breaking change to PHPFUI, but still track Foundation 6.x.  PHPFUI 7.0.0 would track Foundation 7.x series.

## Depreciation and Foundation changes
Since major versions of Foundation have in the past depreciated and obsoleted things, PHPFUI will track the latest version of Foundation for class names and functionality. However, when Foundation makes a breaking change or removes something, PHPFUI will continue to support the old functionality as best as possible in the new Foundation framework. Depreciated classes will be put in the \PHPFUI\Vx namespace (where x would be the prior Major Foundation version containing that feature). So if something gets depreciated in a newer version of Foundation, you simply will need to change your code from \PHPFUI\Example to \PHPFUI\V6\Example.  The depreciated namespace will only be supported for one Major version of PHPFUI, so it is recommended you migrate off of it in a timely manor.

## Documentation
Via [PHPFUI/InstaDoc](http://phpfui.com/?n=PHPFUI)

## Live Examples
Via [PHPFUI/Examples](http://phpfui.com/Examples/index.php)

## Unit Testing
Full unit testing using [phpfui/html-unit-tester](https://packagist.org/packages/phpfui/html-unit-tester)

## License
PHPFUI is distributed under the MIT License.

### PHP Versions
This library only supports **modern** versions of PHP which still receive security updates. While we would love to support PHP from the late Ming Dynasty, the advantages of modern PHP versions far out weigh quaint notions of backward compatibility. Time to upgrade.
