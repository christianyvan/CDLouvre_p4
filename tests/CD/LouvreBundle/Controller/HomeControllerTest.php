<?php
/**
 * Created by PhpStorm.
 * User: Christian
 * Date: 25/05/2018
 * Time: 17:16
 */

namespace Tests\CD\LouvreBundle\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class HomeControllerTest extends WebTestCase
{

	/**
	 * test de chargement de la page
	 * @test
	 */
	public function home_load()
	{
		$client = static::createClient();
		$client->request('GET','/');
		$this->assertTrue($client->getResponse()->isSuccessful());
		$this->assertContains('Billetterie du Musée du Louvre', $client->getResponse()->getContent());
	}


}