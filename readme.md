# PHPFUI
PHP Wrapper for Zurb Foundation

PHPFUI, PHP Foundation User Interface, is a 7.1 PHP library that produces HTML formated for [Zurb Foundation](https://foundation.zurb.com/sites/docs/).  It does everything you need for a fully functional Foundation page, with the power of a OO language. It currently uses Foundation 6.5 and PHP 7.1 or higher.

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

## Documenation
PHPDOC Blocks.

## License
PHPFUI is distributed under the MIT License.
