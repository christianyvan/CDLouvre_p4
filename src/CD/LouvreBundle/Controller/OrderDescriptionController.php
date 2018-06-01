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

	public function descriptionAction($id){
	//public function descriptionAction(Request $request){

		// on récupère la commande grace à son id
		$purchaseOrder = $this->getDoctrine()
			->getManager()
			->getRepository('CDLouvreBundle:PurchaseOrder')
			->find($id);

		if ($purchaseOrder === null) {
			throw new NotFoundHttpException("La commande : ".$id." est introuvable.");
		}

		// Récupération de la liste des visiteurs associé au bon de commande
		$ticketsDescription = $purchaseOrder->getTicketDescription();

		// si aucun visiteurs associé à la commande on lève une exception
		if ($ticketsDescription === null) {
			throw new NotFoundHttpException("Pas de visiteurs associés à la commande n° ".$id);
		}

/* on récupère la variable de session 'purchaseOrder'
		$session = $request->getSession();
		$purchaseOrder = $session->get('purchaseOrder');*/


	// si aucun visiteurs associé à la commande on lève une exception


			return $this->render('@CDLouvre/OrderPayment/orderDescription.html.twig', array(
				'purchaseOrder' => $purchaseOrder,
				'ticketsDescription' => $ticketsDescription
			));
	}
}