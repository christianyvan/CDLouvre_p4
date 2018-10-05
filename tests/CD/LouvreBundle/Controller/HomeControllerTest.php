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
	 * test  fonctionnel chargement de la page
	 * @test
	 */
	public function home_load()
	{
		$client = static::createClient();
		$client->request('GET','/');
		$this->assertSame(200,$client->getResponse()->getStatusCode());
		echo $client->getResponse()->getContent();
		//$this->assertTrue($client->getResponse()->isSuccessful());
		//$this->assertContains('Billetterie du Musée du Louvre', $client->getResponse()->getContent());
	}


	/**
	 * test fonctionnel du contenu
	 * $test
	 */
	public function homePage(){
		$client = static::createClient();
		$crawler = $client->request('GET','/');
		$this->assertSame(1,$crawler->filter('html:contains("Achat de billet(s) pour visiter le musée du Louvre")')->count());


	}


}