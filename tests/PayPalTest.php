<?php

namespace PHPFUI\PayPal;

class PayPalTest extends \PHPUnit\Framework\TestCase
	{

	public function testAddress() : void
		{
		$address = new Address();

		$fields = [
			'address_line_1' => '123 Townsend St',
		];

		$address->address_line_1 = '123 Townsend St';
		$this->assertEquals($fields, $address->getData());

		$fields['postal_code'] = '94107';
		$address->postal_code = '94107';
		$this->assertEquals($fields, $address->getData());

		$this->expectException(\Exception::class);
		$address->postal_code = 12345;
		}

	public function testBreakdown() : void
		{
		$breakdown = new Breakdown();

		$this->assertEquals([], $breakdown->getData());

		$breakdown->item_total = new Currency(180.00);
		$breakdownExample = [
			'item_total' =>
				[
					'currency_code' => 'USD',
					'value' => '180.00',
				],
			];
		$this->assertEquals($breakdownExample, $breakdown->getData());

		$breakdownExample['shipping'] = ['currency_code' => 'USD', 'value' => '20.00', ];
		$breakdown->shipping = new Currency(20.00);
		$this->assertEquals($breakdownExample, $breakdown->getData());
		}

	public function testCurrency() : void
		{
		$zero = new Currency();

		$data = $zero->getData();
		$this->assertIsArray($data);

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
		$applicationContent = new ApplicationContent();

		$this->expectException(\Exception::class);
		$applicationContent->landing_page = 'TOM';
		}

	public function testGetExceptions() : void
		{
		$zero = new Currency();

		$this->expectException(\Exception::class);
		$amount = $zero->amount;
		}

	public function testOrder() : void
		{
		$orderExample = [
			'intent' => 'CAPTURE',
			'application_context' =>
				[
					'brand_name' => 'EXAMPLE INC',
					'locale' => 'en-US',
					'landing_page' => 'BILLING',
					'shipping_preferences' => 'SET_PROVIDED_ADDRESS',
					'user_action' => 'PAY_NOW',
				],
			'purchase_units' =>
				[
					0 =>
						[
							'reference_id' => 'PUHF',
							'description' => 'Sporting Goods',
							'custom_id' => 'CUST-HighFashions',
							'soft_descriptor' => 'HighFashions',
							'amount' =>
								[
									'currency_code' => 'USD',
									'value' => '220.00',
									'breakdown' =>
										[
											'item_total' =>
												[
													'currency_code' => 'USD',
													'value' => '180.00',
												],
											'shipping' =>
												[
													'currency_code' => 'USD',
													'value' => '20.00',
												],
											'handling' =>
												[
													'currency_code' => 'USD',
													'value' => '10.00',
												],
											'tax_total' =>
												[
													'currency_code' => 'USD',
													'value' => '20.00',
												],
											'shipping_discount' =>
												[
													'currency_code' => 'USD',
													'value' => '10.00',
												],
										],
								],
							'items' =>
								[
									0 =>
										[
											'name' => 'T-Shirt',
											'description' => 'Green XL',
											'sku' => 'sku01',
											'unit_amount' =>
												[
													'currency_code' => 'USD',
													'value' => '90.00',
												],
											'tax' =>
												[
													'currency_code' => 'USD',
													'value' => '10.00',
												],
											'quantity' => '1',
											'category' => 'PHYSICAL_GOODS',
										],
									1 =>
										[
											'name' => 'Shoes',
											'description' => 'Running, Size 10.5',
											'sku' => 'sku02',
											'unit_amount' =>
												[
													'currency_code' => 'USD',
													'value' => '45.00',
												],
											'tax' =>
												[
													'currency_code' => 'USD',
													'value' => '5.00',
												],
											'quantity' => '2',
											'category' => 'PHYSICAL_GOODS',
										],
								],
							'shipping' =>
								[
									'method' => 'United States Postal Service',
									'address' =>
										[
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

		$this->assertEquals($orderExample, $order->getData());

		$this->expectException(\Exception::class);
		$bad = new Order('invalid');
		}

	public function testSetExceptions() : void
		{
		$zero = new Currency();

		$this->expectException(\Exception::class);
		$zero->amount = 10.0;
		}

	}
