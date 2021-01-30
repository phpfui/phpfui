<?php

namespace PHPFUI\Input;

/**
 * A MonthYear edit field pair for entering month and year
 * values without an associated day. Example credit card
 * expiration dates.
 */
class MonthYear extends \PHPFUI\Base
	{
	use \PHPFUI\Traits\Page;

	protected $hidden;

	protected $label;

	protected $monthSelect;

	protected $name;

	protected $page;

	protected $yearSelect;

	private $day = 1;

	private $maxYear = 2100;

	private $minYear = 2000;

	private $month;

	private $required;

	private $year;

	/**
	 * Construct a MonthYear field
	 *
	 * @param \PHPFUI\Interfaces\Page $page required JS
	 * @param string $name of field
	 * @param string $label optional
	 * @param ?string $value optional
	 */
	public function __construct(\PHPFUI\Interfaces\Page $page, string $name, string $label = '', ?string $value = '')
		{
		parent::__construct();
		$this->page = $page;
		$this->name = $name;
		$this->label = $label;
		$this->hidden = new \PHPFUI\Input\Hidden($name, $value);
		$this->year = \date('Y');
		$this->month = \date('n');
		$array = \explode('/', \str_replace(['-',
			'.',
			'\\',
			' ', ], '/', $value));

		if (3 == \count($array))
			{
			[$this->year, $this->month, $this->day] = $array;
			}
		}

	/**
	 * So the field can be treated like a full date, set the default
	 * day. Use 0 for last day of the month
	 *
	 * @param int $day defaults to today's date
	 */
	public function setDay(int $day) : MonthYear
		{
		$this->day = $day;

		return $this;
		}

	/**
	 * Set the maximum allowed year (4 digits)
	 */
	public function setMaxYear(int $max) : MonthYear
		{
		$this->maxYear = $max;

		return $this;
		}

	/**
	 * Set the minimum allowed year (4 digits)
	 */
	public function setMinYear(int $min) : MonthYear
		{
		$this->minYear = $min;

		return $this;
		}

	public function setRequired(bool $required = true) : MonthYear
		{
		$this->required = $required;

		return $this;
		}

	protected function getBody() : string
		{
		$row = new \PHPFUI\GridX();
		$columnA = new \PHPFUI\Cell(6);
		$columnA->add($this->monthSelect);
		$row->add($columnA);
		$columnB = new \PHPFUI\Cell(6);
		$columnB->add($this->yearSelect);
		$row->add($columnB);
		$row->add($this->hidden);

		return "{$row}";
		}

	protected function getEnd() : string
		{
		return '';
		}

	protected function getStart() : string
		{
		$this->monthSelect = new Select($this->name . 'Month', $this->label . ' Month');
		$jd = new \DateTime();

		for ($i = 1; $i <= 12; ++$i)
			{
			$jd->setDate(2000, $i, 10);
			$this->monthSelect->addOption($i . ' - ' . $jd->format('F'), $i, $this->month == $jd->format('n'));
			}

		$this->yearSelect = new Select($this->name . 'Year', $this->label . ' Year', $this->year, 4);

		if ($this->required)
			{
			$this->monthSelect->setRequired();
			$this->yearSelect->setRequired();
			}

		for ($i = $this->minYear; $i <= $this->maxYear; ++$i)
			{
			$this->yearSelect->addOption($i, $i, $this->year == $i);
			}

		$monthId = $this->monthSelect->getId();
		$yearId = $this->yearSelect->getId();
		$hiddenId = $this->hidden->getId();
		$computeDate = "MonthYear(\"{$monthId}\",\"{$yearId}\",\"{$hiddenId}\");";
		$this->yearSelect->addAttribute('onchange', $computeDate);
		$this->monthSelect->addAttribute('onchange', $computeDate);
		$js = <<<JAVASCRIPT
var daysInMonth=[];daysInMonth[1]=31;daysInMonth[2]=28;daysInMonth[3]=31;daysInMonth[4]=30;daysInMonth[5]=31;daysInMonth[6]=30;daysInMonth[7]=31;daysInMonth[8]=31;daysInMonth[9]=30;daysInMonth[10]=31;daysInMonth[11]=30;daysInMonth[12]=31;
function MonthYear(monthId,yearId,hidden){var month=$('#'+monthId).val();var year=$('#'+yearId).val();var day={$this->day};
if(day>daysInMonth[month]||day<1)day=daysInMonth[month];$('#'+hidden).val(year+'-'+month+'-'+day);}
JAVASCRIPT;
		$this->page->addJavaScript($js);

		return '';
		}
	}
