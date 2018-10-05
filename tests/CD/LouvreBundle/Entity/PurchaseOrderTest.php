<?php
/**
 * Created by PhpStorm.
 * User: Christian
 * Date: 25/05/2018
 * Time: 19:01
 */

namespace Tests\CD\LouvreBundle\Entity;


use CD\LouvreBundle\Entity\PurchaseOrder;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PurchaseOrderTest extends WebTestCase
{

	/**
	 * @test
	 */
	public function get_number_places()
	{
		$purchaseOrder = new PurchaseOrder();
		$purchaseOrder->setNumberTicketsDesired(1);
		$this->assertEquals(1, $purchaseOrder->getNumberTicketsDesired());
	}

	/**
	 * @test
	 */
	public function set_type_reservation()
	{
		$purchaseOrder = new PurchaseOrder();
		$purchaseOrder->setVisitType(true);
		$this->assertEquals(true, $purchaseOrder->getVisitType());
	}

	/**
	 * @test
	 */
	public function set_order_validation()
	{
		$purchaseOrder = new PurchaseOrder();
		$purchaseOrder->setOrderValidation(true);
		$this->assertEquals(true, $purchaseOrder->getOrderValidation());
	}



}