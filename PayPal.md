# PHPFUI PayPal Options

There are two ways to interface easily with PayPal. Checkout is recommended as the PayPal PHP wrapper for Express is abandoned.

## PayPal Express (not recommended or supported but still works)
```PHP
$page = new \PHPFUI\Page();
$express = new \PHPFUI\PayPal\Express($page, $yourClientId);
$express->setType('sandbox);
$express->setPaymentUrl($root . '/Paypal/CreatePayment');
$express->setExecuteUrl($root . '/Paypal/AuthorizePayment');
$express->setErrorUrl($root . '/Paypal/ErrorPayment');
$page->add($express);
echo $page;
```

You will then need to implement the above endpoints using the abandoned [paypal/rest-api-sdk-php](https://packagist.org/packages/paypal/rest-api-sdk-php) package.

## PayPal Checkout (recommended)

```PHP
$page = new \PHPFUI\Page();
$container = new \PHPFUI\HTML5Element('div'); // this element's html will be replaced by JavaScript below
$container->add(new \PHPFUI\Header('Pay For Your Order'));
$checkout = new \PHPFUI\PayPal\Checkout($page, $yourClientId);
$head = 'https://www.YourDomain.com/PayPal/';
$executeUrl = $head . 'CompletedPayment';
$createOrderUrl = $head . 'CreateOrder';
$completedUrl = $head . 'Completed';
$cancelledUrl = $head . 'Cancelled';
$errorUrl = $head . 'Error';
$dollar = '$';
$id = $container->getId();
// Example JavaScript, change as needed for your pages
$checkout->setFunctionJavaScript('onCancel', "{$dollar}.post('{$cancelledUrl}',JSON.stringify({orderID:data.orderID}),function(data){{$dollar}('#{$id}').html(data.html)})");
$checkout->setFunctionJavaScript('onError', "{$dollar}.post('{$errorUrl}',JSON.stringify({data:data,actions:actions}),function(data){{$dollar}('#{$id}').html(data.html)})");
$checkout->setFunctionJavaScript('createOrder', "return fetch('{$createOrderUrl}',{method:'post',headers:{'content-type':'application/json'}}).
	then(function(res){return res.json();}).then(function(data){return data.id;})");
$checkout->setFunctionJavaScript('onApprove', "return fetch('{$executeUrl}',{method:'POST',headers:{'content-type':'application/json'},body:JSON.stringify({orderID:data.orderID})}).
	then(function(res){return res.json();}).
	then(function(details){if(details.error==='INSTRUMENT_DECLINED'){return actions.restart();}
	$.post('{$completedUrl}',JSON.stringify({orderID:data.orderID}),function(data){{$dollar}('#{$id}').html(data.html)})})");
$container->add($checkout);
$page->add($container);
echo $page;
```

You will then need to implement the above endpoints using [paypal/paypal-checkout-sdk](https://packagist.org/packages/paypal/paypal-checkout-sdk) package.

You can use the PHPFUI\PayPal classes to format the JSON response. They are fully type checked and bounded to avoid stupid errors.
### Example createOrder
```PHP
namespace \PHPFUI\PayPal;

$order = new Order('CAPTURE');

$applicationContent = new ApplicationContent();
$applicationContent->brand_name = 'EXAMPLE INC';
$applicationContent->locale = 'en-US';
$applicationContent->landing_page = 'BILLING';
$applicationContent->shipping_preferences = 'SET_PROVIDED_ADDRESS';
$applicationContent->user_action = 'PAY_NOW';
$order->setApplicationContent($applicationContent);

$purchase_unit = new PurchaseUnit();
$purchase_unit->reference_id = 'PUHF';
$purchase_unit->description = 'Sporting Goods';
$purchase_unit->custom_id = 'CUST-HighFashions';
$purchase_unit->soft_descriptor = 'HighFashions';
$amount = new Amount();
$amount->setCurrency(new Currency(220.00));
$breakdown = new Breakdown();
$breakdown->item_total = new Currency(180.00);
$breakdown->shipping = new Currency(20.00);
$breakdown->handling = new Currency(10.00);
$breakdown->tax_total = new Currency(20.00);
$breakdown->shipping_discount = new Currency(10.00);

$amount->breakdown = $breakdown;
$purchase_unit->amount = $amount;

$shipping = new Shipping();
$shipping->method = 'United States Postal Service';
$address = new Address();
$address->address_line_1 = '123 Townsend St';
$address->address_line_2 = 'Floor 6';
$address->admin_area_2 = 'San Francisco';
$address->admin_area_1 = 'CA';
$address->postal_code = '94107';
$address->country_code = 'US';
$shipping->address = $address;
$purchase_unit->shipping = $shipping;

$item = new Item('T-Shirt', 1, new Currency(90.00));
$item->description = 'Green XL';
$item->sku = 'sku01';
$item->tax = new Currency(10.00);
$item->category = 'PHYSICAL_GOODS';
$purchase_unit->addItem($item);

$item = new Item('Shoes', 2, new Currency(45.00));
$item->description = 'Running, Size 10.5';
$item->sku = 'sku02';
$item->tax = new Currency(5.00);
$item->category = 'PHYSICAL_GOODS';
$purchase_unit->addItem($item);

$order->addPurchaseUnit($purchase_unit);

$request = new \PayPalCheckoutSdk\Orders\OrdersCreateRequest();
$request->prefer('return=representation');
$request->body = $order->getData();
$env = new \PayPalCheckoutSdk\Core\SandboxEnvironment($yourClientId, $yourSecret);
$client = new \PayPalCheckoutSdk\Core\PayPalHttpClient($env);
$response = $client->execute($request);
$page = new \PHPFUI\Page();
$page->setRawResponse(json_encode($response->result, JSON_PRETTY_PRINT));
echo $page;
```
### Example onApprove
You will probably want to save the generated orderId from the above and check it here for additional validation. You will also want to do what ever processing you need to save and process the payment.
```PHP
$json = json_decode(file_get_contents('php://input'), true);
$request = new \PayPalCheckoutSdk\Orders\OrdersCaptureRequest($json['orderID']);
$request->prefer('return=representation');
$env = new \PayPalCheckoutSdk\Core\SandboxEnvironment($yourClientId, $yourSecret);
$client = new \PayPalCheckoutSdk\Core\PayPalHttpClient($env);
$response = $client->execute($request);
$result = $response->result;
$txn = $result->purchase_units[0]->payments->captures[0]->id;
$status = $result->purchase_units[0]->payments->captures[0]->status;
$payment_amount = $result->purchase_units[0]->payments->captures[0]->amount->value;
$page = new \PHPFUI\Page();
$page->setRawResponse(json_encode($response->result, JSON_PRETTY_PRINT));
echo $page;
```
### Example Completed, onError or onCancel
Return the HTML that will be use to replace the original PayPal buttons.  You can also pass other things back as needed.
```PHP
$json = json_decode(file_get_contents('php://input'), true);
$container = new \PHPFUI\Container();
$container->add(new \PHPFUI\Header('Thanks for your PayPal Payment'));
$pre = new \PHPFUI\HTML5Element('pre');
$pre->add(print_r($json, 1));
$container->add($pre);
$response = ['html' => "{$container}"];
$page = new \PHPFUI\Page();
$page->setRawResponse(json_encode($response, JSON_PRETTY_PRINT));
echo $page;
```
