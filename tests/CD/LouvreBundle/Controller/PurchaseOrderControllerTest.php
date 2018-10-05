<?php
/**
 * Created by PhpStorm.
 * User: Christian
 * Date: 30/09/2018
 * Time: 17:29
 */

namespace Tests\CD\LouvreBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class PurchaseOrderControllerTest extends WebTestCase
{

	public function testAddNewPurchaseOrder(){
		$client = static::createClient();
		$crawler = $client->request('GET','/');
		$form = $crawler->selectButton('submit')->form();
		$form["cd_louvrebundle_purchaseorder[visitType]"] = '1';
		$form["cd_louvrebundle_purchaseorder[visitDate]"] = '01/09/2018';
		$form["cd_louvrebundle_purchaseorder[numberTicketsDesired]"] = 0;
		$form["cd_louvrebundle_purchaseorder[customerEmail]"] = 'christian_diiorio@yahoo.fr';
		$form["cd_louvrebundle_purchaseorder[ticketDescription][0][visitorLastName]"] = 'Di Iorio';
		$form["cd_louvrebundle_purchaseorder[ticketDescription][0][visitorFirstName]"] = 'Christian';
		$form["cd_louvrebundle_purchaseorder[ticketDescription][0][visitorBirthDate][day]"] = "28";
		$form["cd_louvrebundle_purchaseorder[ticketDescription][0][visitorBirthDate][month]"] = "05";
		$form["cd_louvrebundle_purchaseorder[ticketDescription][0][visitorBirthDate][year]"] = "1965";
		$form["cd_louvrebundle_purchaseorder[ticketDescription][0][visitorCountry]"] = "FR";

		$var = $client->submit($form);
		//$crawler = $client->followRedirect();
		dump($var);
		//echo $client->getResponse()->getContent();
	}
}