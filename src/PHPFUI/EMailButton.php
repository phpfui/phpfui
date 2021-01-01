<?php

namespace PHPFUI;

/**
 * Makes a Button displayable in all email clients
 */
class EMailButton extends \PHPFUI\Button
	{
	protected $backgroundColor = '008cba';

	protected $backgroundImage = '';

	protected $borderColor = '008cba';

	protected $color = 'ffffff';

	protected $font = 'sans-serif';

	protected $fontSize = 13;

	protected $height = 40;

	protected $radius = 3;

	protected $width = 150;

	/**
	 * Construct an EMailButton
	 *
	 * @param string $text for button
	 */
	public function __construct(string $text, string $link = '')
		{
		parent::__construct($text, $link);
		}

	/**
	 * Set the background color
	 */
	public function setBackgroundColor(string $backgroundColor) : EMailButton
		{
		$this->backgroundColor = $backgroundColor;

		return $this;
		}

	/**
	 * Set a background image
	 *
	 * @param string $backgroundImage path to image
	 */
	public function setBackgroundImage(string $backgroundImage) : EMailButton
		{
		$this->backgroundImage = $backgroundImage;

		return $this;
		}

	/**
	 * Set the border color
	 */
	public function setBorderColor(string $borderColor) : EMailButton
		{
		$this->borderColor = $borderColor;

		return $this;
		}

	/**
	 * Set the main button color
	 */
	public function setColor(string $color) : EMailButton
		{
		$this->color = $color;

		return $this;
		}

	/**
	 * Set the font name
	 */
	public function setFont(string $font) : EMailButton
		{
		$this->font = $font;

		return $this;
		}

	/**
	 * Set the font size in pixels
	 */
	public function setFontSize(int $fontSize) : EMailButton
		{
		$this->fontSize = $fontSize;

		return $this;
		}

	/**
	 * Set the button height in pixels
	 */
	public function setHeight(int $height) : EMailButton
		{
		$this->height = $height;

		return $this;
		}

	/**
	 * Set the button radius in pixels
	 */
	public function setRadius(int $radius) : EMailButton
		{
		$this->radius = $radius;

		return $this;
		}

	/**
	 * Set the button width in pixels
	 */
	public function setWidth(int $width) : EMailButton
		{
		$this->width = $width;

		return $this;
		}

	protected function getBody() : string
		{
		if ($this->backgroundImage)
			{
			$fill = 'fill="t"><v:fill type="tile" src="' . $this->backgroundImage . '" color="#' . $this->backgroundColor . '" />';
			}
		else
			{
			$fill = 'fillcolor="#' . $this->backgroundColor . '">';
			}

		return <<<BUTTON
<span><!--[if mso]>
<v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word"
href="{$this->link}" style="height:{$this->height}px;v-text-anchor:middle;width:{$this->width}px;"
arcsize="{round({$this->radius}*2.5)}%" strokecolor="#{$this->borderColor}" {$fill}
<w:anchorlock/>
<center style="color:#{$this->color};font-family:{$this->font};font-size:{$this->fontSize}px;font-weight:bold;">{$this->text}</center>
</v:roundrect>
<![endif]--><a href="{$this->link}"
style="background-color:#{$this->backgroundColor};border:1px solid #{$this->borderColor};border-radius:{$this->radius}px;
color:#{$this->color};display:inline-block;font-family:{$this->font};font-size:{$this->fontSize}px;
font-weight:bold;line-height:{$this->height}px;text-align:center;text-decoration:none;
width:{$this->width}px;-webkit-text-size-adjust:none;mso-hide:all;">{$this->text}</a></span>
BUTTON;
		}
	}
