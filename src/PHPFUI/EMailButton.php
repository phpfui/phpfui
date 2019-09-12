<?php

namespace PHPFUI;

/**
 * Makes a Button displayable in all email clients
 */
class EMailButton extends Button
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
   * @param string $link
   */
  public function __construct($text, $link = '')
    {
    parent::__construct($text, $link);
    }

  /**
   * Set the background color
   *
   * @param string $backgroundColor
   *
   * @return EMailButton
   */
  public function setBackgroundColor($backgroundColor)
    {
    $this->backgroundColor = $backgroundColor;

    return $this;
    }

  /**
   * Set a background image
   *
   * @param string $backgroundImage path to image
   *
   * @return EMailButton
   */
  public function setBackgroundImage($backgroundImage)
    {
    $this->backgroundImage = $backgroundImage;

    return $this;
    }

  /**
   * Set the border color
   *
   * @param string $borderColor
   *
   * @return EMailButton
   */
  public function setBorderColor($borderColor)
    {
    $this->borderColor = $borderColor;

    return $this;
    }

  /**
   * Set the main button color
   *
   * @param string $color
   *
   * @return EMailButton
   */
  public function setColor($color)
    {
    $this->color = $color;

    return $this;
    }

  /**
   * Set the font name
   *
   * @param string $font
   *
   * @return EMailButton
   */
  public function setFont($font)
    {
    $this->font = $font;

    return $this;
    }

  /**
   * Set the font size in pixels
   *
   * @param int $fontSize
   *
   * @return EMailButton
   */
  public function setFontSize($fontSize)
    {
    $this->fontSize = $fontSize;

    return $this;
    }

  /**
   * Set the button height in pixels
   *
   * @param int $height
   *
   * @return EMailButton
   */
  public function setHeight($height)
    {
    $this->height = $height;

    return $this;
    }

  /**
   * Set the button radius in pixels
   *
   * @param int $radius
   *
   * @return EMailButton
   */
  public function setRadius($radius)
    {
    $this->radius = $radius;

    return $this;
    }

  /**
   * Set the button width in pixels
   *
   * @param int $width
   *
   * @return EMailButton
   */
  public function setWidth($width)
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
