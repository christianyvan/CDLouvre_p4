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
	 * fonction qui renvoie le nombre de places disponibles pour une date donnée (requète ajax)
	 * @return int|Response
	 * @throws \Doctrine\ORM\NoResultException
	 * @throws \Doctrine\ORM\NonUniqueResultException
	 */
	public function numberPlacesAction()
	{
		$visitDate = $_GET['visitDate'];
		$em = $this->getDoctrine()->getManager();
		$result = $em->getRepository('CDLouvreBundle:PurchaseOrder')->placesPerDay($visitDate);
		$places = PurchaseOrder::MAX_PLACES_PER_DAY - $result;

		$response = new Response($places);
		return $response;
	}

	/**
	 * fonction qui récupère la liste des dates qui n'ont plus de places disponibles. Le résultat est retourné a la
	 * requète ajax, les dates seront désactivées dans le datepicker.
	 * @return JsonResponse
	 */
	public function disponibilityDayAction()
	{
		$excludedDate = array();

		// Traitement des dates dont le nbre de billets MAX est atteint
		$em = $this->getDoctrine()->getManager();

		// Récupération de la liste des dates avec la somme des billets associés
		$datesList = $em->getRepository('CDLouvreBundle:PurchaseOrder')->fullDay();

		// Pour chaque enregistrement de la liste
		foreach ($datesList as $key => $value)
		{
			// Comparaison du Nbre de places total réservées pour chaque date de la liste avec le nombre max de place
			// disponible par jour
			if ($value['Places'] == PurchaseOrder::MAX_PLACES_PER_DAY)
			{

				// Si le nombre de place pour une date est égal au nombre max de place autorisé par jour, on ajoute la date
				// au tableau des dates qui n'ont plus de places disponibles.
				array_push($excludedDate,$value['visitDate']);
			};
		}
		$response = new JsonResponse($excludedDate);

		return $response;
	}
}