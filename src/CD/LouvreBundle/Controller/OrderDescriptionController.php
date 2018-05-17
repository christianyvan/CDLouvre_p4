<?php
/**
 * Created by PhpStorm.
 * User: Christian
 * Date: 16/05/2018
 * Time: 11:05
 */

namespace CD\LouvreBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class OrderDescriptionController extends Controller
{
	public function descriptionAction(Request $request){

// on récupère la variable de session 'purchaseOrder'
		$session = $request->getSession();
		$purchaseOrder = $session->get('purchaseOrder');

// Récupération de la liste des visiteurs associé au bon de commande
		$ticketsDescription = $purchaseOrder->getTicketDescription();

// si aucun visiteurs associé à la commande on lève une exception
		if ($ticketsDescription === null)
		{
			throw new NotFoundHttpException("Pas de visiteurs associés à la commande ");
		}
		else
		{

			return $this->render('@CDLouvre/OrderPayment/orderDescription.html.twig', array(
				'purchaseOrder' => $purchaseOrder,
				'ticketsDescription' => $ticketsDescription
			));
		}
	}
}