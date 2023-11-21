<?php

namespace PHPFUI;

/**
 * Makes a Button displayable in all email clients
 */
class EMailButton extends \PHPFUI\Base
	{
	protected string $backgroundColor = '008cba';

	protected string $backgroundImage = '';

	protected string $borderColor = '008cba';

	protected string $color = 'ffffff';

	protected string $font = 'sans-serif';

	protected int $fontSize = 13;

	protected int $height = 40;

	protected int $radius = 3;

	protected int $width = 150;

	/**
	 * Construct an EMailButton
	 *
	 * @param string $text for button
	 */
	public function __construct(protected string $text, protected string $link = '')
		{
		}

	/**
	 * Set the background color
	 */
	public function setBackgroundColor(string $backgroundColor) : static
		{
		$this->backgroundColor = $backgroundColor;

		return $this;
		}

	/**
	 * Set a background image
	 *
	 * @param string $backgroundImage path to image
	 */
	public function setBackgroundImage(string $backgroundImage) : static
		{
		$this->backgroundImage = $backgroundImage;

		return $this;
		}

	/**
	 * Set the border color
	 */
	public function setBorderColor(string $borderColor) : static
		{
		$this->borderColor = $borderColor;

		return $this;
		}

	/**
	 * Set the main button color
	 */
	public function setColor(string $color) : static
		{
		$this->color = $color;

		return $this;
		}

	/**
	 * Set the font name
	 */
	public function setFont(string $font) : static
		{
		$this->font = $font;

		return $this;
		}

	/**
	 * Set the font size in pixels
	 */
	public function setFontSize(int $fontSize) : static
		{
		$this->fontSize = $fontSize;

		return $this;
		}

	/**
	 * Set the button height in pixels
	 */
	public function setHeight(int $height) : static
		{
		$this->height = $height;

		return $this;
		}

	/**
	 * Set the button radius in pixels
	 */
	public function setRadius(int $radius) : static
		{
		$this->radius = $radius;

		return $this;
		}

	/**
	 * Set the button width in pixels
	 */
	public function setWidth(int $width) : static
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

	protected function getEnd() : string
		{
		return '';
		}

	protected function getStart() : string
		{
		return '';
		}
	}
