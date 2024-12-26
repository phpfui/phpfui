<?php

class PayPalTest extends \PHPUnit\Framework\TestCase
	{
	public function testAddress() : void
		{
		$address = new \PHPFUI\PayPal\Address();

		$fields = [
			'address_line_1' => '123 Townsend St',
		];

		$address->address_line_1 = '123 Townsend St';
		$this->assertEquals($fields, $address->getData());

		$fields['postal_code'] = '94107';
		$address->postal_code = '94107';
		$this->assertEquals($fields, $address->getData());

		$this->expectException(\Exception::class);
		// @phpstan-ignore-next-line
		$address->postal_code = 12345;
		}

	public function testBreakdown() : void
		{
		$breakdown = new \PHPFUI\PayPal\Breakdown();

		$this->assertEquals([], $breakdown->getData());

		$breakdown->item_total->value = 180.00;
		$breakdownExample = [
			'item_total' => [
				'currency_code' => 'USD',
				'value' => '180.00',
			],
		];
		$this->assertEquals($breakdownExample, $breakdown->getData());

		$breakdownExample['shipping'] = ['currency_code' => 'EUR', 'value' => '20.00', ];
		$breakdown->shipping->value = 20.00;
		$breakdown->shipping->currency_code = 'EUR';
		$this->assertEquals($breakdownExample, $breakdown->getData());
		}

	public function testCurrency() : void
		{
		$zero = new \PHPFUI\PayPal\Currency();

		$data = $zero->getData();

		$this->assertArrayHasKey('value', $data);
		$this->assertArrayHasKey('currency_code', $data);

		$this->assertEquals(['currency_code' => 'USD', 'value' => 0.0], $data);

		// should not throw exception
		$zero->value = 10.0;
		$zero->currency_code = 'HKD';

		$data = $zero->getData();
		$this->assertEquals(['currency_code' => 'HKD', 'value' => 10.0], $data);
		}

	public function testEnumValidation() : void
		{
		$applicationContent = new \PHPFUI\PayPal\ApplicationContext();

		$this->expectException(\Exception::class);
		$applicationContent->landing_page = 'TOM';
		}

	public function testGetExceptions() : void
		{
		$zero = new \PHPFUI\PayPal\Currency();

		$this->expectException(\Exception::class);
		// @phpstan-ignore-next-line
		$amount = $zero->amount;
		}

	public function testOrder() : void
		{
		$orderExample = [
			'intent' => 'CAPTURE',
			'application_context' => [
				'brand_name' => 'EXAMPLE INC',
				'locale' => 'en-US',
				'landing_page' => 'BILLING',
				'shipping_preference' => 'SET_PROVIDED_ADDRESS',
				'user_action' => 'PAY_NOW',
			],
			'purchase_units' => [
				0 => [
					'reference_id' => 'PUHF',
					'description' => 'Sporting Goods',
					'custom_id' => 'CUST-HighFashions',
					'soft_descriptor' => 'HighFashions',
					'amount' => [
						'currency_code' => 'USD',
						'value' => '220.00',
						'breakdown' => [
							'item_total' => [
								'currency_code' => 'USD',
								'value' => '180.00',
							],
							'shipping' => [
								'currency_code' => 'USD',
								'value' => '20.00',
							],
							'handling' => [
								'currency_code' => 'USD',
								'value' => '10.00',
							],
							'tax_total' => [
								'currency_code' => 'USD',
								'value' => '20.00',
							],
							'shipping_discount' => [
								'currency_code' => 'USD',
								'value' => '10.00',
							],
						],
					],
					'items' => [
						0 => [
							'name' => 'T-Shirt',
							'description' => 'Green XL',
							'sku' => 'sku01',
							'unit_amount' => [
								'currency_code' => 'USD',
								'value' => '90.00',
							],
							'tax' => [
								'currency_code' => 'USD',
								'value' => '10.00',
							],
							'quantity' => '1',
							'category' => 'PHYSICAL_GOODS',
						],
						1 => [
							'name' => 'Shoes',
							'description' => 'Running, Size 10.5',
							'sku' => 'sku02',
							'unit_amount' => [
								'currency_code' => 'USD',
								'value' => '45.00',
							],
							'tax' => [
								'currency_code' => 'USD',
								'value' => '5.00',
							],
							'quantity' => '2',
							'category' => 'PHYSICAL_GOODS',
						],
					],
					'shipping' => [
						'method' => 'United States Postal Service',
						'address' => [
							'address_line_1' => '123 Townsend St',
							'address_line_2' => 'Floor 6',
							'admin_area_2' => 'San Francisco',
							'admin_area_1' => 'CA',
							'postal_code' => '94107',
							'country_code' => 'US',
						],
					],
				],
			],
		];


		$order = new \PHPFUI\PayPal\Order('CAPTURE');
		$applicationContext = new \PHPFUI\PayPal\ApplicationContext();
		$applicationContext->brand_name = 'EXAMPLE INC';
		$applicationContext->locale = 'en-US';
		$applicationContext->landing_page = 'BILLING';
		$applicationContext->shipping_preference = 'SET_PROVIDED_ADDRESS';
		$applicationContext->user_action = 'PAY_NOW';

		$order->application_context = $applicationContext;

		$purchase_unit = new \PHPFUI\PayPal\PurchaseUnit();
		$purchase_unit->reference_id = 'PUHF';
		$purchase_unit->description = 'Sporting Goods';
		$purchase_unit->custom_id = 'CUST-HighFashions';
		$purchase_unit->soft_descriptor = 'HighFashions';
		$amount = new \PHPFUI\PayPal\Amount();
		$amount->setCurrency(new \PHPFUI\PayPal\Currency(220.00));
		$breakdown = new \PHPFUI\PayPal\Breakdown();
		$breakdown->item_total = new \PHPFUI\PayPal\Currency(180.00);
		$breakdown->shipping = new \PHPFUI\PayPal\Currency(20.00);
		$breakdown->handling = new \PHPFUI\PayPal\Currency(10.00);
		$breakdown->tax_total = new \PHPFUI\PayPal\Currency(20.00);
		$breakdown->shipping_discount = new \PHPFUI\PayPal\Currency(10.00);

		$amount->breakdown = $breakdown;
		$purchase_unit->amount = $amount;

		$purchase_unit->shipping->method = 'United States Postal Service';
		$purchase_unit->shipping->address->address_line_1 = '123 Townsend St';
		$purchase_unit->shipping->address->address_line_2 = 'Floor 6';
		$purchase_unit->shipping->address->admin_area_2 = 'San Francisco';
		$purchase_unit->shipping->address->admin_area_1 = 'CA';
		$purchase_unit->shipping->address->postal_code = '94107';
		$purchase_unit->shipping->address->country_code = 'US';

		$item = new \PHPFUI\PayPal\Item('T-Shirt', 1, new \PHPFUI\PayPal\Currency(90.00));
		$item->description = 'Green XL';
		$item->sku = 'sku01';
		$item->tax = new \PHPFUI\PayPal\Currency(10.00);
		$item->category = 'PHYSICAL_GOODS';
		$purchase_unit->addItem($item);

		$item = new \PHPFUI\PayPal\Item('Shoes', 2, new \PHPFUI\PayPal\Currency(45.00));
		$item->description = 'Running, Size 10.5';
		$item->sku = 'sku02';
		$item->tax = new \PHPFUI\PayPal\Currency(5.00);
		$item->category = 'PHYSICAL_GOODS';
		$purchase_unit->addItem($item);

		$order->addPurchaseUnit($purchase_unit);

		$this->assertEquals($orderExample, $order->getData());

		$this->expectException(\Exception::class);
		$bad = new \PHPFUI\PayPal\Order('invalid');
		}

	public function testPlan() : void
		{
		$expected = \json_decode('{
  "product_id": "PROD-XXCD1234QWER65782",
  "name": "Video Streaming Service Plan",
  "description": "Video Streaming Service basic plan",
  "status": "ACTIVE",
  "billing_cycles": [
    {
      "frequency": {
        "interval_unit": "MONTH",
        "interval_count": 1
      },
      "tenure_type": "TRIAL",
      "sequence": 1,
      "total_cycles": 1,
      "pricing_scheme": {
        "fixed_price": {
          "value": "10.00",
          "currency_code": "USD"
        }
      }
    },
    {
      "frequency": {
        "interval_unit": "MONTH",
        "interval_count": 1
      },
      "tenure_type": "REGULAR",
      "sequence": 2,
      "total_cycles": 12,
      "pricing_scheme": {
        "fixed_price": {
          "value": "100.00",
          "currency_code": "USD"
        }
      }
    }
  ],
  "payment_preferences": {
    "auto_bill_outstanding": true,
    "setup_fee": {
      "value": "10.00",
      "currency_code": "USD"
    },
    "setup_fee_failure_action": "CONTINUE",
    "payment_failure_threshold": 3
  },
  "taxes": {
    "percentage": "10",
    "inclusive": false
  }
}', true);

		$plan = new \PHPFUI\PayPal\Plan();
		$plan->product_id = 'PROD-XXCD1234QWER65782';
		$plan->name = 'Video Streaming Service Plan';
		$plan->description = 'Video Streaming Service basic plan';
		$plan->status = 'ACTIVE';
		$taxes = new \PHPFUI\PayPal\Taxes();
		$taxes->percentage = '10';
		$taxes->inclusive = false;
		$plan->taxes = $taxes;

		$paymentPreferences = new \PHPFUI\PayPal\PaymentPreferences();
		$paymentPreferences->auto_bill_outstanding = true;
		$paymentPreferences->setup_fee = new \PHPFUI\PayPal\Currency(10);
		$paymentPreferences->setup_fee_failure_action = 'CONTINUE';
		$paymentPreferences->payment_failure_threshold = 3;
		$plan->payment_preferences = $paymentPreferences;

		$billingCycle = new \PHPFUI\PayPal\BillingCycle();
		$frequency = new \PHPFUI\PayPal\Frequency();
		$frequency->interval_unit = 'MONTH';
		$frequency->interval_count = 1;
		$billingCycle->frequency = $frequency;
		$billingCycle->tenure_type = 'TRIAL';
		$billingCycle->sequence = 1;
		$billingCycle->total_cycles = 1;
		$pricingScheme = new \PHPFUI\PayPal\PricingScheme();
		$pricingScheme->fixed_price = new \PHPFUI\PayPal\Currency(10);
		$billingCycle->pricing_scheme = $pricingScheme;
		$plan->addBillingCycle($billingCycle);

		$billingCycle = new \PHPFUI\PayPal\BillingCycle();
		$billingCycle->frequency = $frequency;
		$billingCycle->tenure_type = 'REGULAR';
		$billingCycle->sequence = 2;
		$billingCycle->total_cycles = 12;
		$pricingScheme = new \PHPFUI\PayPal\PricingScheme();
		$pricingScheme->fixed_price = new \PHPFUI\PayPal\Currency(100);
		$billingCycle->pricing_scheme = $pricingScheme;
		$plan->addBillingCycle($billingCycle);

		$this->assertEquals($expected, $plan->getData());
		}

	public function testSetExceptions() : void
		{
		$zero = new \PHPFUI\PayPal\Currency();

		$this->expectException(\Exception::class);
		// @phpstan-ignore-next-line
		$zero->amount = 10.0;
		}

	public function testSubscription() : void
		{
		$expected = \json_decode('{
  "plan_id": "P-5ML4271244454362WXNWU5NQ",
  "start_time": "2018-11-01T00:00:00Z",
  "quantity": "20",
  "shipping_amount": {
    "currency_code": "USD",
    "value": "10.00"
  },
  "subscriber": {
    "name": {
      "given_name": "John",
      "surname": "Doe"
    },
    "email_address": "customer@example.com",
    "shipping_address": {
      "name": {
        "full_name": "John Doe"
      },
      "address": {
        "address_line_1": "2211 N First Street",
        "address_line_2": "Building 17",
        "admin_area_2": "San Jose",
        "admin_area_1": "CA",
        "postal_code": "95131",
        "country_code": "US"
      }
    }
  },
  "application_context": {
    "brand_name": "walmart",
    "locale": "en-US",
    "shipping_preference": "SET_PROVIDED_ADDRESS",
    "user_action": "SUBSCRIBE_NOW",
    "payment_method": {
      "payer_selected": "PAYPAL",
      "payee_preferred": "IMMEDIATE_PAYMENT_REQUIRED"
    },
    "return_url": "https://example.com/returnUrl",
    "cancel_url": "https://example.com/cancelUrl"
  }
}', true);

		$subscription = new \PHPFUI\PayPal\Subscription();
		$subscription->plan_id = 'P-5ML4271244454362WXNWU5NQ';
		$subscription->start_time = '2018-11-01T00:00:00Z';
		$subscription->quantity = '20';
		$subscription->shipping_amount = new \PHPFUI\PayPal\Currency(10.0);
		$application_context = new \PHPFUI\PayPal\ApplicationContext();
		$application_context->brand_name = 'walmart';
		$application_context->locale = 'en-US';
		$application_context->shipping_preference = 'SET_PROVIDED_ADDRESS';
		$application_context->user_action = 'SUBSCRIBE_NOW';
		$application_context->return_url = 'https://example.com/returnUrl';
		$application_context->cancel_url = 'https://example.com/cancelUrl';
		$paymentMethod = new \PHPFUI\PayPal\PaymentMethod();
		$paymentMethod->payer_selected = 'PAYPAL';
		$paymentMethod->payee_preferred = 'IMMEDIATE_PAYMENT_REQUIRED';
		$application_context->payment_method = $paymentMethod;
		$subscription->application_context = $application_context;

		$subscriber = new \PHPFUI\PayPal\Subscriber();
		$name = new \PHPFUI\PayPal\Name();
		$name->given_name = 'John';
		$name->surname = 'Doe';
		$subscriber->name = $name;
		$subscriber->email_address = 'customer@example.com';
		$shippingAddress = new \PHPFUI\PayPal\ShippingDetail();
		$name = new \PHPFUI\PayPal\Name();
		$name->full_name = 'John Doe';
		$shippingAddress->name = $name;
		$address = new \PHPFUI\PayPal\Address();
		$address->address_line_1 = '2211 N First Street';
		$address->address_line_2 = 'Building 17';
		$address->admin_area_2 = 'San Jose';
		$address->admin_area_1 = 'CA';
		$address->postal_code = '95131';
		$address->country_code = 'US';
		$shippingAddress->address = $address;
		$subscriber->shipping_address = $shippingAddress;
		$subscription->subscriber = $subscriber;

		$this->assertEquals($expected, $subscription->getData());
		}
	}
