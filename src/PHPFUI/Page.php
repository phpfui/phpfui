<?php

namespace PHPFUI;

/**
 * A container to add objects to that will output a fully formed Foundation page.
 */
class Page extends Base
  {
  private $android = false;
  private $chrome = false;
  private $css = [];
  private $edgeVersion = 0;
  private $favIcon;
  private $fireFoxVersion = 0;
  private $foundationStyleSheets = [];
  private $headJavascript = [];
  private $headScripts = [];
  private $headTags = [
    '<meta charset="utf-8">',
    '<meta name="viewport" content="width=device-width, initial-scale=1.0" />',
    '<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css" />',
  ];
  private $ieComments = [];
  private $IEMobile = false;
  private $ios = false;
  private $javascript = [];
  private $javascriptLast = [];
  private $language = 'en';
  private $pageName = 'Created with Zurb Foundation';

  private $plugins = [];
  private $reveals = [];
  private $styleSheets = [];
  private $tailScripts = [];

  public function __construct()
    {
    parent::__construct();
    $client = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $this->android = preg_match('/Android|Silk/i', $client);
    $this->ios = preg_match('/iPhone|iPad|iPod/i', $client);
    $this->IEMobile = preg_match('/IEMobile/i', $client);

    if ($index = strpos($client, ' Firefox/'))
      {
      $this->fireFoxVersion = (int)substr($client, $index + 9);
      }
    elseif ($index = strpos($client, ' Edge/'))
      {
      $this->edgeVersion = (int)substr($client, $index + 6);
      }
    else
      {
      $this->chrome = strpos($client, ' Chrome/') > 0;
      }
    }

  /**
   * Add dedupped inline css
   *
   *
   */
  public function addCSS(string $css) : Page
    {
    $this->css[sha1($css)] = $css;

    return $this;
    }

  /**
   * Add dedupped JavaScript to the header
   *
   *
   */
  public function addHeadJavaScript(string $js) : Page
    {
    $this->headJavascript[sha1($js)] = $js;

    return $this;
    }

  /**
   * Add a dedupped header script
   *
   * @param string $module path to script
   *
   */
  public function addHeadScript(string $module) : Page
    {
    $this->headScripts[$module] = $module;

    return $this;
    }

  /**
   * Add a meta tag to the head section of the page
   *
   *
   */
  public function addHeadTag(string $tag) : Page
    {
    $this->headTags[] = $tag;

    return $this;
    }

  /**
   * Add IE commands.  For example you should restrict IE 8 and lower clients.
   * $page->addIEComments('<!--[if lt IE9]><script>window.location="/old/index.html";</script><![endif]-->');
   *
   *
   */
  public function addIEComments(string $comment) : Page
    {
    $this->ieComments[] = $comment;

    return $this;
    }

  /**
   * Add dedupped JavaScript to the page
   *
   *
   */
  public function addJavaScript(string $js) : Page
    {
    $this->javascript[sha1($js)] = $js;

    return $this;
    }

  /**
   * Add dedupped JavaScript as the last JavaScript on the page
   *
   *
   */
  public function addJavaScriptLast(string $js) : Page
    {
    $this->javascriptLast[sha1($js)] = $js;

    return $this;
    }

  /**
   * You can add various plugin default parameters
   */
  public function addPluginDefault(string $pluginName, string $property, string $value) : Page
    {
    $this->plugins[$pluginName][$property] = $value;

    return $this;
    }

  /**
   * Add a reveal dialog to the page
   *
   * @param Reveal $reveal dialog to store in the page
   *
   */
  public function addReveal(Reveal $reveal) : Page
    {
    $this->reveals[] = $reveal;

    return $this;
    }

  /**
   * Add dedupped Style Sheet to the page
   *
   * @param string $module filename
   *
   */
  public function addStyleSheet(string $module) : Page
    {
    $this->styleSheets[$module] = $module;

    return $this;
    }

  /**
   * Add a dedupped script to the end of the page
   *
   * @param string $module path to script
   *
   */
  public function addTailScript(string $module) : Page
    {
    $this->tailScripts[$module] = $module;

    return $this;
    }

  /**
   * Return just the base URI without the query string
   *
   */
  public function getBaseURL() : string
    {
    $url = $_SERVER['REQUEST_URI'] ?? '';
    $queryStart = strpos($url, '?');

    if ($queryStart)
      {
      $url = substr($url, 0, $queryStart);
      }

    return $url;
    }

  /**
   * Return the Fav Icon
   *
   */
  public function getFavIcon() : string
    {
    return $this->favIcon;
    }

  /**
   * Return the current page name
   *
   */
  public function getPageName() : string
    {
    return $this->pageName;
    }

  /**
   * Returns array of the current query parameters
   */
  public function getQueryParameters() : array
    {
    $parameters = [];
    $url = $_SERVER['REQUEST_URI'] ?? '';
    $queryStart = strpos($url, '?');

    if ($queryStart)
      {
      parse_str(substr($url, $queryStart + 1), $parameters);
      }

    return $parameters;
    }

  /**
   * return true if it has a built in date picker detectable by
   * HTTP_USER_AGENT
   */
  public function hasDatePicker() : bool
    {
    return $this->android || $this->ios || $this->IEMobile || $this->fireFoxVersion >= 57 || $this->chrome;
    }

  /**
   * return true if it has a built in date time picker detectable
   * by HTTP_USER_AGENT
   */
  public function hasDateTimePicker() : bool
    {
    return $this->android || $this->ios || $this->IEMobile;
    }

  /**
   * return true if it has a built in time picker detectable by
   * HTTP_USER_AGENT
   */
  public function hasTimePicker() : bool
    {
    return $this->android || $this->IEMobile;
    }

  /**
   * Return true if Android platform
   *
   */
  public function isAndroid() : bool
    {
    return $this->android;
    }

  /**
   * Return true if Chrome browser
   *
   */
  public function isChrome() : bool
    {
    return $this->chrome;
    }

  /**
   * Return true if Windows Mobile browser
   *
   */
  public function isIEMobile() : bool
    {
    return $this->IEMobile;
    }

  /**
   * Return true if IOS platform
   *
   */
  public function isIOS() : bool
    {
    return $this->ios;
    }

  /**
   * Redirect page.  Default will redirect to the current page
   * minus query string.  Pass formatted query string as
   * $parameter with no leading ?.
   *
   * @param string $url default '', current url
   * @param string $parameters default ''
   * @param int $timeout default 0
   *
   * @return \PHPFUI\Page
   */
  public function redirect(string $url = '', string $parameters = '', int $timeout = 0) : Page
    {
    if (empty($url))
      {
      $url = $this->getBaseURL();
      $questionIndex = strpos($url, '?');

      if ($questionIndex)
        {
        $url = substr($url, 0, $questionIndex);
        }
      }

    if (! empty($parameters))
      {
      $pos = strpos($url, '?');

      if ($pos > 0)
        {
        $url = substr($url, 0, $pos);
        }

      if ('?' != $parameters[0])
        {
        $parameters = '?' . $parameters;
        }
      }
    $timeout = (int) $timeout;

    if (! $timeout)
      {
      header("location: {$url}{$parameters}");
      $this->done();
      }
    else
      {
      $this->addHeadTag("<meta http-equiv='refresh' content='{$timeout};url={$url}{$parameters}'>");
      }

    return $this;
    }

  /**
   * Sets the Fav Icon (shown in browser tabs and elsewhere in the
   * browser
   *
   * @param string $path to favicon
   *
   */
  public function setFavIcon(string $path) : Page
    {
    $this->favIcon = $path;

    return $this;
    }

  /**
   * Set the page language
   *
   *
   */
  public function setLanguage(string $lang) : Page
    {
    $this->language = $lang;

    return $this;
    }

  /**
   * Set the page name.  Defaults to "Created with Zurb
   * Foundation"
   *
   * @param string $name of page
   *
   */
  public function setPageName(string $name) : Page
    {
    $this->pageName = $name;

    return $this;
    }

  protected function getBody() : string
    {
    return '';
    }

  protected function getEnd() : string
    {
    $nl = parent::getDebug() ? "\n" : '';
    $output = '';

    if (count($this->reveals))
      {
      foreach ($this->reveals as &$reveal)
        {
        $output .= $reveal;
        }
      }
    $scripts = [
      '/foundation/js/vendor/jquery.min.js',
      '/foundation/js/vendor/what-input.min.js',
      '/foundation/js/foundation.js',
    ];
    $scripts = array_merge($scripts, $this->tailScripts);

    foreach ($scripts as $src)
      {
      $output .= "<script src='{$src}'></script>{$nl}";
      }
    $output .= '<script>';

    foreach ($this->plugins as $plugin => $options)
      {
      foreach ($options as $name => $value)
        {
        $output .= "Foundation.{$plugin}.defaults.{$name}={$value};";
        }
      }
    $output .= '$(document).foundation();' . $nl;
    $this->javascript = array_merge($this->javascript, $this->javascriptLast);

    foreach ($this->javascript as $js)
      {
      $output .= "{$js};{$nl}";
      }
    $output .= '</script></body></html>';

    return $output;
    }

  protected function getStart() : string
    {
    $nl = parent::getDebug() ? "\n" : '';
    $output = '<!DOCTYPE html>' . $nl;

    foreach ($this->ieComments as $comment)
      {
      $output .= $comment;
      }
    $output .= "<html class='no-js' lang='{$this->language}'>{$nl}<head>";

    foreach ($this->headTags as $tag)
      {
      $output .= $tag;
      }

    if ($this->favIcon)
      {
      $output .= "<link rel='shortcut icon' href='{$this->favIcon}' />{$nl}";
      }
    $output .= "<title>{$this->pageName}</title>{$nl}";
    // always place foundation css first
    $this->styleSheets = array_merge($this->foundationStyleSheets, $this->styleSheets);

    foreach ($this->styleSheets as $sheet)
      {
      $output .= "<link rel='stylesheet' href='{$sheet}'>{$nl}";
      }

    foreach ($this->headScripts as $src)
      {
      $output .= "<script src='{$src}'></script>{$nl}";
      }

    foreach ($this->headJavascript as $src)
      {
      $output .= "<script>{$src}</script>{$nl}";
      }

    if ($this->css)
      {
      $output .= '<style>' . implode(';', $this->css) . '</style>' . $nl;
      }
    $output .= '</head><body>';

    return $output;
    }

  }
