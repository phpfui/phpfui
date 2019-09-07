# PHPFUI [![Build Status](https://travis-ci.org/phpfui/phpfui.png?branch=master)](https://travis-ci.org/phpfui/phpfui)

PHP Wrapper for Zurb Foundation

PHPFUI, PHP Foundation User Interface, is a 7.1 PHP library that produces HTML formated for [Zurb Foundation](https://foundation.zurb.com/sites/docs/).  It does everything you need for a fully functional Foundation page, with the power of a OO language. It currently uses Foundation 6.5 and PHP 7.1 or higher.

> "I was surprised that people were prepared to write HTML. In my initial requirements for this thing, I had assumed, as an absolute pre-condition, that nobody would have to do HTML or deal with URLs. If you use the original World Wide Web program, you never see a URL or have to deal with HTML. You're presented with the raw information. You then input more information. So you are linking information to information--like using a word processor. That was a surprise to me--that people were prepared to painstakingly write HTML."

[Sir Tim Berners-Lee, inventor of the World Wide Web](http://web.archive.org/web/20050831085206/http://www.w3journal.com/3/s1.interview.html)

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
* Place your style sheet in /css/style.css.  It will be added last.

## Documentation
PHPDOC Blocks.

## License
PHPFUI is distributed under the MIT License.
