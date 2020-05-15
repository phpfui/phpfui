<?php

namespace PHPFUI\PayPal;

/**
 * An OO wrapper around the PayPal Checkout API
 *
 * ### Usage:
 *
 * 1. Create a Checkout object passing in the page and your client id from PayPal.
 * 2. Set the CreateOrderUrl path. This will be called as a GET.
 * 3. In CreateOrderUrl, create an Order according to [PayPal docs](https://developer.paypal.com/docs/api/orders/v2/#orders_capture) using the \PHPFUI\PayPal\Order class.
 * 4. Return the orderId from \PayPalCheckoutSdk\Orders\OrdersCreateRequest as JSON
 * 5. Set the ExecuteUrl path. This will be called as a POST with the JSON data from PayPal confirming the transaction. Process the information as you see fit.
 * 6. Add the Checkout object to the page where you want it to appear.
 */
class Checkout extends \PHPFUI\HTML5Element
	{
	private $executeUrl = '';
	private $createOrderUrl = '';
	private $page;

	public function __construct(\PHPFUI\Page $page, string $clientId)
		{
		parent::__construct('div');
		$this->page = $page;
		$this->page->addHeadScript('https://www.paypal.com/sdk/js?client-id=' . $clientId);
		}

	public function setExecuteUrl(string $url) : self
		{
		$this->executeUrl = $url;

		return $this;
		}

	public function setCreateOrderUrl(string $url) : self
		{
		$this->createOrderUrl = $url;

		return $this;
		}

	protected function getStart() : string
		{
		if (! $this->executeUrl)
			{
			throw new \Exception(__CLASS__ . ' executeUrl is not set');
			}

		if (! $this->createOrderUrl)
			{
			throw new \Exception(__CLASS__ . ' createOrderUrl is not set');
			}

		$id = $this->getId();
		$js = "paypal.Buttons({createOrder:function(){return fetch('{$this->createOrderUrl}',{
    method:'post',headers:{'content-type':'application/json'}
  }).then(function(res){console.log('createOrder.then res');console.log(res);return res.json();
  }).then(function(data){console.log('createOrder.then data');console.log(data);return data.orderID;
  });
},
			onApprove: function(data,actions) {console.log('onApprove');
console.log(data);console.log(actions);
  return fetch('{$this->executeUrl}', {
    headers: {
      'content-type': 'application/json'
    },
    body: data
  }).then(function(res) {console.log('onApprove.then res');console.log(res);return res.json();
  }).then(function(details) {console.log('onApprove.then details');console.log(details);
			alert('Transaction funds captured from ' + details.payer_given_name);
  })
}
		}).render('#{$id}');";

		$this->page->addJavaScript($js);

		return parent::getStart();
		}
	}
