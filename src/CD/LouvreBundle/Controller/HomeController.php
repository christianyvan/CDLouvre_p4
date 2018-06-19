<?php
/**
 * Created by PhpStorm.
 * User: Christian
 * Date: 16/05/2018
 * Time: 11:06
 */

namespace CD\LouvreBundle\Controller;

use CD\LouvreBundle\Entity\PurchaseOrder;
use CD\LouvreBundle\Form\PurchaseOrderType;
use CD\LouvreBundle\Services\CDOrderHandling;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HomeController extends Controller
{


	/**
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 * @throws \Exception
	 */
	public function homeAction(Request $request){

		$em = $this->getDoctrine()->getManager();

		$orderHandling = $this->get('louvre.cdorder_handling');

		// on crée un bon de commande
		$purchaseOrder = new PurchaseOrder();

		// on récupère le formulaire associé à l'entité PurchaseOrder dans la variable $form
		$form = $this->createForm(PurchaseOrderType::class,$purchaseOrder);

		if ($request->isMethod('POST'))
		{
		// on hydrate l'entité PurchaseOrder avec les donnée transmise via la méthode POST
		// $purchaseOrder contient maintenant les données du formulaire
			$form->handleRequest($request);

			if ($form->isSubmitted() && $form->isValid())
			{

				$em->persist($purchaseOrder);
				$em->flush();

				// récupération de la description des tickets commander par le visiteur
				$ticketsDescription=$purchaseOrder->getTicketDescription();


				// calcul du montant de la commande en utilisant la fonction setOrderAmount du service CDOrderHandling
				$amountOrder=$orderHandling->setOrderAmount($purchaseOrder,$ticketsDescription);

				// on renseigne le montant de la commande de l'entité PurchaseOrder $purchaseOrder
				$purchaseOrder->setAmountOrder($amountOrder);

				$em->persist($purchaseOrder);
				$em->flush();

				// Redirection vers la page de description de la commande
				return $this->redirectToRoute('louvre_description',array(
					'id'=>$purchaseOrder->getId()
				));
			}
		}

		return $this->render('CDLouvreBundle:Home:home.html.twig', array(
			'form' => $form->createView(),
		));
	}
}