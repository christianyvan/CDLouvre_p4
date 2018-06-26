<?php
/**
 * Created by PhpStorm.
 * User: Christian
 * Date: 16/05/2018
 * Time: 11:09
 */

namespace CD\LouvreBundle\Controller;
use CD\LouvreBundle\Entity\PurchaseOrder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;



class RecoveryDisponibilityController extends Controller
{
	/**
	 * @param $dateTab
	 * @return int|Response
	 */
	public function numberPlacesAction($dateTab)
	{

		//if($request->isXmlHttpRequest()){

		$em = $this->getDoctrine()->getManager();
		$result = $em->getRepository('CDLouvreBundle:PurchaseOrder')->placesPerDay($dateTab);
		$places = PurchaseOrder::MAX_PLACES_PER_DAY - $result;
		$response = new Response($places);
		var_dump($response);die('hello');
		if($places > 0){
			return $response;
		}

		else{
			$response = 0;

			return $response;
		}
	}

	public function disponibilityDayAction()
	{

		$excludedDate = array();

		// Ajout des dates de fermeture dans la variable $excludedDate
		array_push($excludedDate, strtotime('2018-05-01'));
		array_push($excludedDate, strtotime('2018-11-01'));
		array_push($excludedDate, strtotime('2018-12-25'));

		// Traitement des dates dont le nbre de billets MAX est atteint
		$em = $this->getDoctrine()->getManager();

		// Récupération de la liste des dates avec la somme des billets associés
		$datesList = $em->getRepository('CDLouvreBundle:PurchaseOrder')->fullDay();

		// Pour chaque enregistrement de la liste
		foreach ($datesList as $key => $value)
		{
			// Test du Nbre de places total pour chaque date de la liste
			if ($value['Places'] == PurchaseOrder::MAX_PLACES_PER_DAY)
			{

				// Si le nombre de place pour une date est égal au nombre max de place autorisé par jour, on ajoute la date
				// au tableau des dates qui n'ont plus de places disponibles.
				array_push($excludedDate, strtotime($value['visitDate']));
			};
		}
		$response = new JsonResponse($excludedDate);
		var_dump($response);die('coucou');
		return $response;
	}
}