<?php

namespace PHPFUI\PayPal;

/**
 * An OO wrapper around the PayPal Checkout API
 *
 * ### Usage:
 *
 * 1. Create a Checkout object passing in the page and your client id from PayPal.
 * 2. Use setFunctionJavaScript to specify the JavaScript to be executed for each of the following actions: onCancel, createOrder, onApprove and optionally onError
 * 3. Create createOrder and onApprove callbacks in PHP according to [PayPal docs](https://developer.paypal.com/docs/api/orders/v2/#orders_capture) using the \PHPFUI\PayPal\Order class.
 * 4. Add the Checkout object to the page where you want it to appear.
 */
class Checkout extends \PHPFUI\HTML5Element
	{
	use \PHPFUI\Traits\Page;

	private array $functions = [];

	private \PHPFUI\Interfaces\Page $page;

	private array $styles = [
		'layout' => 'vertical',
		'size' => 'responsive',
		'shape' => 'pill',
		'color' => 'gold',
		'label' => 'checkout',
	];

	public function __construct(\PHPFUI\Interfaces\Page $page, string $clientId)
		{
		parent::__construct('div');
		$this->page = $page;
		$this->page->addHeadScript('https://www.paypal.com/sdk/js?client-id=' . $clientId);
		}

	/**
	 * You can [style the PayPal buttons](https://developer.paypal.com/docs/archive/checkout/how-to/customize-button/#)
	 */
	public function addStyle(string $style, ?string $value = null) : self
		{
		if (null === $value)
			{
			unset($this->styles[$style]);
			}
		else
			{
			$this->styles[$style] = $value;
			}

		return $this;
		}

	public function getStyle() : array
		{
		return $this->styles;
		}

	/**
	 * Set the JavaScript for the function specified. data, actions are passed as parameters to the JavaScript
	 */
	public function setFunctionJavaScript(string $function, string $js) : self
		{
		$this->functions[$function] = $js;

		return $this;
		}

	public function setStyles(array $styles) : self
		{
		$this->styles = $styles;

		return $this;
		}

	protected function getStart() : string
		{
		$id = $this->getId();
		$js = 'paypal.Buttons({style:' . \PHPFUI\TextHelper::arrayToJS($this->styles, "'");

		foreach ($this->functions as $function => $javaScript)
			{
			$js .= ",{$function}:function(data,actions){" . $javaScript . "}\n";
			}
		$js .= "\n}).render('#{$id}')";

		$this->page->addJavaScript($js);

		return parent::getStart();
		}
	}
