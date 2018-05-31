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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HomeController extends Controller
{


	/**
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
	public function homeAction(Request $request){
	//public function homeAction(Request $request,CDOrderHandling $orderHandling){
	$em = $this->getDoctrine()->getManager();
	$orderHandling = new CDOrderHandling($em);

// on crée un bon de commande
		$purchaseOrder = new PurchaseOrder();

// on récupère les services du CDOrderHandling
	//	$orderHandling = $this->container->get('cd_louvre.services.cdorder_handling');


// on récupère le formulaire associé à l'entité PurchaseOrder dans la variable $form
		$form = $this->createForm(PurchaseOrderType::class,$purchaseOrder);

		if ($request->isMethod('POST'))
		{
// on hydrate l'entité PurchaseOrder avec les donnée transmise via la méthode POST
//À partir de maintenant, la variable $data contient les valeurs entrées dans le formulaire par le visiteur

			$form->handleRequest($request);
			$data = $form->getData();

// récupération de la description des tickets commander par le visiteur
			$ticketsDescription = $data->getTicketDescription();
			$purchaseOrder = $data;
// calcul du montant de la commande en utilisant la fonction setOrderAmount du service CDOrderHandling
			$amountOrder = $orderHandling->setOrderAmount($purchaseOrder, $ticketsDescription);
			//$amountOrder = $cdOrderHandling->setOrderAmount($purchaseOrder, $ticketsDescription);

// on met à jour $data avec le nouveau montant de la commande
			$data->setAmountOrder($amountOrder);
			$session = $request->getSession();
// mise en session de la variable $data contenant les données du formulaire et sous formulaire
			$session->set('purchaseOrder',$data);

// Redirection vers la page de description de la commande

			return $this->redirectToRoute('louvre_description');
		}

		return $this->render('CDLouvreBundle:Home:home.html.twig', array(
			'form' => $form->createView(),
		));
	}
}