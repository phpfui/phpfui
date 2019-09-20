<?php

namespace PHPFUI;

include '../vendor/autoload.php';

class State extends Input\SelectAutoComplete
	{

	private static $states = ['AL' => 'Alabama',
			'AK' => 'Alaska',
			'AZ' => 'Arizona',
			'AR' => 'Arkansas',
			'CA' => 'California',
			'CO' => 'Colorado',
			'CT' => 'Connecticut',
			'DE' => 'Delaware',
			'DC' => 'District of Columbia',
			'FL' => 'Florida',
			'GA' => 'Georgia',
			'HI' => 'Hawaii',
			'ID' => 'Idaho',
			'IL' => 'Illinois',
			'IN' => 'Indiana',
			'IA' => 'Iowa',
			'KS' => 'Kansas',
			'KY' => 'Kentucky',
			'LA' => 'Louisiana',
			'ME' => 'Maine',
			'MD' => 'Maryland',
			'MA' => 'Massachusetts',
			'MI' => 'Michigan',
			'MN' => 'Minnesota',
			'MS' => 'Mississippi',
			'MO' => 'Missouri',
			'MT' => 'Montana',
			'NE' => 'Nebraska',
			'NV' => 'Nevada',
			'NH' => 'New Hampshire',
			'NJ' => 'New Jersey',
			'NM' => 'New Mexico',
			'NY' => 'New York',
			'NC' => 'North Carolina',
			'ND' => 'North Dakota',
			'OH' => 'Ohio',
			'OK' => 'Oklahoma',
			'OR' => 'Oregon',
			'PA' => 'Pennsylvania',
			'RI' => 'Rhode Island',
			'SC' => 'South Carolina',
			'SD' => 'South Dakota',
			'TN' => 'Tennessee',
			'TX' => 'Texas',
			'UT' => 'Utah',
			'VT' => 'Vermont',
			'VA' => 'Virginia',
			'WA' => 'Washington',
			'WV' => 'West Virginia',
			'WI' => 'Wisconsin',
			'WY' => 'Wyoming',];

	public function __construct(Page $page, string $name, string $title, $value = '')
		{
		parent::__construct($page, $name, $title);
		$this->addOption('Please select a state', '', empty($value));

		foreach (self::$states as $abbrev => $state)
			{
			$this->addOption($abbrev . ' ' . $state, $abbrev, $value == $abbrev);
			}
		}

	}

$page = new Page();
// You need a reasonable style sheet as well.  Default Foundation will work.
$page->addStyleSheet('/css/style.css');

$mainColumn = new Cell(12);
$mainColumn->addClass('main-column');
$mainColumn->add(new Header('Abide Example'));
$submit = new Submit();

$form = new Form($page, $submit);
$mainColumn->add($form);
$page->add($mainColumn);

if ($form->isMyCallback())
	{
	$page->setResponse('Saved (not really!)');
	echo $page;
	exit;
	}

$nameInfo = new FieldSet('Name and Address');
$firstName = new Input\Text('firstName', 'First Name');
$firstName->setRequired()->setToolTip('We need to know');

$lastName = new Input\Text('lastName', 'Last Name');
$lastName->setRequired()->setToolTip('We need to know');

$nameInfo->add(new MultiColumn($firstName, $lastName));

$nameInfo->add(new Input\Text('address', 'Address'));

$city = new Input\Text('city', 'City');
$city->setRequired();
$state = new State($page, 'state', 'ST');
$state->setRequired();
$zip = new Input\Zip($page, 'zip', 'Zip');

$nameInfo->add(new MultiColumn($city, $state, $zip));
$form->add($nameInfo);

$personalInfo = new FieldSet('Personal Information');
$personalInfo->add(new MultiColumn(new Input\Date($page, 'birthday', 'Birthday'), new Input\Time($page, 'birthTime', 'Birthtime'), new Input\CheckBox('alive', 'Living?')));
$personalInfo->add(new MultiColumn(new Input\Email('email', 'email'), new Input\Tel('cell', 'Cell Number')));
$form->add($personalInfo);

$otherInfo = new FieldSet('Other Information');
$otherInfo->add(new MultiColumn(new Input\Color('color', 'Pick A Color'), new Input\File($page, 'file', 'Upload File'), new Input\Url('url', 'Home Page')));

$form->add($otherInfo);

$buttonGroup = new ButtonGroup();
$buttonGroup->addButton($submit);
$buttonGroup->addButton(new Reset());
$form->add($buttonGroup);
$form->add(new FormError('Please correct the above errors'));

echo $page;

