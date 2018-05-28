<?php
/**
 * Created by PhpStorm.
 * User: Christian
 * Date: 25/05/2018
 * Time: 19:02
 */

namespace Tests\CD\LouvreBundle\Entity;


use CD\LouvreBundle\Entity\TicketDescription;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TicketDescriptionTest extends WebTestCase
{

	/**
	 * @test
	*/
	public function get_ticket_price()
	{
		$ticketDescription = new TicketDescription();
		$ticketDescription->setTicketPrice(16);
		$this->assertEquals(16, $ticketDescription->getTicketPrice());
	}


	/**
	 * @test
	*/
	public function get_visitor_last_name()
	{
		$ticketDescription = new TicketDescription();

		$ticketDescription->setVisitorLastName('TEST');
		$this->assertEquals('TEST', $ticketDescription->getVisitorLastName());
	}

	/**
	 * @test
	*/
	public function get_birth_date()
	{
		$ticketDescription = new TicketDescription();
		$date = Date('Y-m-d', strtotime("1998-05-22"));
		$ticketDescription->setVisitorBirthDate($date);
		$this->assertEquals('1998-05-22', $ticketDescription->getVisitorBirthDate());
	}



}