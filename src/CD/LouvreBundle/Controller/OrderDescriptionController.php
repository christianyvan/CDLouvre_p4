<?php
/**
 * Created by PhpStorm.
 * User: Christian
 * Date: 16/05/2018
 * Time: 11:05
 */

namespace CD\LouvreBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class OrderDescriptionController extends Controller
{
	/**
	 * function qui prend en paramètre l'id d'une commande (PurchaseOrder), qui récupère la commande associé à l'id et la
	 * descriptions des tickets qui sont rattachés à la commande .
	 * La fonction retourne une vue qui va affiché les détails de la commande et des tickets associés
	 * @param $id
	 * @return \Symfony\Component\HttpFoundation\Response
	 */

	public function descriptionAction($id)
	{
		// on récupère la commande grace à son id
		$purchaseOrder = $this->getDoctrine()
			->getManager()
			->getRepository('CDLouvreBundle:PurchaseOrder')
			->find($id);
		if ($purchaseOrder === null)
		{
			throw new NotFoundHttpException("La commande : ".$id." est introuvable.");
		}

		// Récupération de la liste des visiteurs associé au bon de commande
		$ticketsDescription = $purchaseOrder->getTicketDescription();

		// si aucun visiteurs associé à la commande on lève une exception
		if ($ticketsDescription === null)
		{
			throw new NotFoundHttpException("Pas de visiteurs associés à la commande n° ".$id);
		}
		return $this->render('@CDLouvre/OrderPayment/orderDescription.html.twig', array(
			'purchaseOrder' => $purchaseOrder,
			'ticketsDescription' => $ticketsDescription
		));
	}
}