# PHPFUI [![Build Status](https://travis-ci.org/phpfui/phpfui.png?branch=master)](https://travis-ci.org/phpfui/phpfui)

PHP Wrapper for Zurb Foundation

**PHPFUI**, **PHP** **F**oundation **U**ser **I**nterface, is a 7.1 PHP library that produces HTML formated for [Zurb Foundation](https://foundation.zurb.com/sites/docs/).  It does everything you need for a fully functional Foundation page, with the power of a OO language. It currently uses Foundation 6.5 and PHP 7.1 or higher.

> "I was surprised that people were prepared to write HTML. In my initial requirements for this thing, I had assumed, as an absolute pre-condition, that nobody would have to do HTML or deal with URLs. If you use the original World Wide Web program, you never see a URL or have to deal with HTML. You're presented with the raw information. You then input more information. So you are linking information to information--like using a word processor. That was a surprise to me--that people were prepared to painstakingly write HTML."

[Sir Tim Berners-Lee, inventor of the World Wide Web](http://web.archive.org/web/20050831085206/http://www.w3journal.com/3/s1.interview.html)

Using PHPFUI for view output will produce 100% valid HTML and insulate you from future changes to Foundation, your custom HMTL layouts, CSS and JS library changes. You write to a abstract concept (I want a checkbox here), and the library will output a checkbox formated for Foundation. You can inherit from CheckBox and add your own take on a checkbox, and when the graphic designer decides they have the most awesome checkbox ever, you simply change your CheckBox class, and it is changed on every page system wide.

Don't write HTML by hand!

## Usage
```PHP
use PHPFUI;
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

## Dependancies not included in the repo
- [Zurb Foundation 6.5](https://foundation.zurb.com/sites/docs/)
- [Froala WYSIWYG HTML Editor](https://www.froala.com/wysiwyg-editor)
- [Font-Awesome](https://fortawesome.github.io/Font-Awesome/)
- [AnyPicker](https://curioussolutions.in/libraries/anypicker/)
- [Foundation Date Picker](http://foundation-datepicker.peterbeno.com)
- [Slick Carousel](http://kenwheeler.github.io/slick/)
- [JQuery Autocomplete](https://github.com/devbridge/jQuery-Autocomplete)
- [HTML 5 Sortable](http://farhadi.ir/projects/html5sortable)

## Installation Instructions
* Download the above projects and create associated folders in your public folder
  * Zurb Foundation 6.5 => foundation
  * Froala WYSIWYG HTML Editor => froala
  * Font-Awesome => font-awesome
  * AnyPicker => anypicker
  * Foundation Date Picker => datepicker
  * Slick Carousel => slick
  * JQuery Autocomplete => jquery-autocomplete
  * HTML 5 Sortable => html5sortable

## Versioning

Versioning will match the [Zurb Foundation versions](https://github.com/zurb/foundation-sites/releases/) for Major and Minor Semantic Versions.  PHPFUI patch level will be set in by the Patch version.  So PHPFUI Version 6.5.0 would be the first version of the library, 6.5.1 would be the first patch of PHPFUI. Both should work with any Foundation 6.5.x version.

## Documentation
PHPDOC Blocks.  PHPFUI/InstaDoc coming soon.

## Examples
#### Add the following files to a public directory for testing
* [kitchenSink.php](https://github.com/phpfui/phpfui/blob/master/examples/kitchenSink.php) examples to show most classes.
* [paginate.php](https://github.com/phpfui/phpfui/blob/master/examples/paginate.php) allows you to test pagination parametes.
* [sortableTable.php](https://github.com/phpfui/phpfui/blob/master/examples/sortableTable.php) interactive SortableTable example with pagination.
* [abide.php](https://github.com/phpfui/phpfui/blob/master/examples/abide.php) a more realistic Abide demo.

## Unit Testing
#### Also good for some basic usage examples
* [PHPFUI\KitchenSink.php](https://github.com/phpfui/phpfui/blob/master/src/PHPFUI/KitchenSink.php) Example generating class used for unit testing.

## License
PHPFUI is distributed under the MIT License.
