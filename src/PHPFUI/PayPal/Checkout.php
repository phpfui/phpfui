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

	/** @var array<string, string> */
	private array $functions = [];

	/** @var array<string, string> */
	private array $options = [];

	/** @var array<string, string> */
	private array $styles = [
		'layout' => 'vertical',
		'size' => 'responsive',
		'shape' => 'pill',
		'color' => 'gold',
		'label' => 'checkout',
	];

	public function __construct(protected \PHPFUI\Interfaces\Page $page, string $clientId)
		{
		parent::__construct('div');
		$this->options['client-id'] = $clientId;
		}

	public function addOption(string $option, string $value) : static
		{
		$this->options[$option] = $value;

		return $this;
		}

	/**
	 * You can [style the PayPal buttons](https://developer.paypal.com/docs/archive/checkout/how-to/customize-button/#)
	 */
	public function addStyle(string $style, ?string $value = null) : static
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

	/** @return array<string, string> */
	public function getStyle() : array
		{
		return $this->styles;
		}

	/**
	 * Set the JavaScript for the function specified. data, actions are passed as parameters to the JavaScript
	 */
	public function setFunctionJavaScript(string $function, string $js) : static
		{
		$this->functions[$function] = $js;

		return $this;
		}

	/** @param array<string, string> $styles */
	public function setStyles(array $styles) : static
		{
		$this->styles = $styles;

		return $this;
		}

	protected function getStart() : string
		{
		$this->page->addHeadScript('https://www.paypal.com/sdk/js?' . \http_build_query($this->options));
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
