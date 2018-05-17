<?php
/**
 * Created by PhpStorm.
 * User: Christian
 * Date: 16/05/2018
 * Time: 11:08
 */

namespace CD\LouvreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class OrderPaymentController extends Controller
{
	public function prepareAction()
	{
		return $this->render('CDLouvreBundle:OrderPayment:prepare.html.twig');
	}


	public function viewAction($id)
	{
		// On redirige vers la page Order pour l'instant avec le contenu de la réservation
		$purchaseOrder = $this->getDoctrine()
			->getManager()
			->getRepository('CDLouvreBundle:PurchaseOrderBundle:PurchaseOrder')
			->find($id);
		$ticketsDescription = $purchaseOrder->getTicketDescription();

		return $this->render('CDLouvreBundle:OrderPayment:prepare.html.twig', array(
			'purchaseOrder' => $purchaseOrder,
			'ticketsDescription' => $ticketsDescription
		));
	}


	public function paymentStripeAction(Request $request)
	{

		\Stripe\Stripe::setApiKey("sk_test_6bsPGo1gZmnZGtkvdl6lbqbC");

		$em = $this->getDoctrine()->getManager();

		// Récupération des élements de paiement
		$token = $request->request->get('stripeToken');

		$email = $request->request->get('stripeEmail'); // Récupérée depuis Stripe

		$amount = $request->request->get('amount');
		$id = $request->request->get('idRes');
		// Créer une charge: cela facturera la carte de l'utilisateur
		try {
			$charge = \Stripe\Charge::create(array(
				"amount" => $amount * 100, // Montant en centimes
				"currency" => "eur",
				"source" => $token,
				"description" => 'Paiement Stripe de : '. $amount . '€ pour la commande de l\'adresse Email : ' . $email
			));
			// Inscription de l'échange dans le fichier log
			//$logger = new Logger('charge');
			// Création du channel
			//$logger->pushHandler(new StreamHandler('./var/logs/charges.log', Logger::NOTICE));
			// Enregistrement dans la log
			//$logger->addNotice('Contenu de la charge : ' . $charge);

			// MAJ du Montant total de la réservation
			//$purchaseOrder = $em->getRepository('CDLouvreBundle:PurchaseOrder')->find($id);*/

			$session = $request->getSession();
			$purchaseOrder = $session->get('purchaseOrder');
			$ticketsDescription = $purchaseOrder->getTicketDescription();

			// on récupère les services du CDOrderHandling
			$orderHandling = $this->container->get('cd_louvre.services.cdorder_handling');
			$purchaseOrder->setOrderValidation(true);
			$em = $this->getDoctrine()->getManager();
			$em->persist($purchaseOrder);
			$em->flush();
			// on affecte l'id du PurchaseOrder à tout les TicketDescription de la commande
			$orderHandling->updateIdTicketsDescription($purchaseOrder, $ticketsDescription);



			//$ticketsDescription = $purchaseOrder->getTicketDescription();
			//dump($purchaseOrder);
			//dump($ticketsDescription[0]);
			//dump($ticketsDescription[1]);
			//$em->persist($purchaseOrder);
			//$em->flush();
			return $this->redirectToRoute('cd_louvre_sendMail', array('code' =>$purchaseOrder->getReservationCode()));

		} catch(\Stripe\Error\Card $e) {
			return $this->redirectToRoute('cd_louvre_view');
			// The card has been declined
		}
	}

	public function sendMailAction($code)
	{

		// On réaffiche l'ensemble de la réservation avec le détail
		$purchaseOrder = $this->getDoctrine()
			->getManager()
			->getRepository('CDLouvreBundle:PurchaseOrder')
			->findOneBy(array('reservationCode' => $code));
		$ticketsDescription = $purchaseOrder->getTicketDescription();

		// Préparation de l'email avec les informations de la commande
		$message = \Swift_Message::newInstance()
			->setSubject('Musée du Louvre - Validation de votre commande : [' .$purchaseOrder->getReservationCode() . ']')
			->setFrom(array('christian.yvan@gmail.com' => "Musée du Louvre"))
			->setTo($purchaseOrder->getCustomerEmail())
			->setCharset('utf-8')
			->setContentType('text/html')
			->setBody($this->renderView('CDLouvreBundle:Email:email.html.twig', array(
				'purchaseOrder'   	  =>$purchaseOrder,
				'ticketDescription'   =>$ticketsDescription
			)));
		// Envoi du mail
		$this->get('mailer')
			->send($message);

		// Retourne la vue de validation
		return $this->render('CDLouvreBundle:OrderPayment:paymentValided.html.twig', array(
			'purchaseOrder'			 => $purchaseOrder,
			'ticketsDescription'	 => $ticketsDescription
		));
	}


	// test du mail a
	public function mailTestAction($code)
	{
		// On réaffiche l'ensemble de la réservation avec le détail
		$purchaseOrder = $this->getDoctrine()
			->getManager()
			->getRepository('CDLouvreBundle:PurchaseOrderBundle:PurchaseOrder')
			->findOneBy(array('codeReservation' => $code));
		$ticketsDescription = $purchaseOrder->getTicketDescription();


		// Retourne la vue de validation
		return $this->render('CDLouvreBundle:Email:email.html.twig', array(
			'purchaseOrder' => $purchaseOrder,
			'ticketsDescription' => $ticketsDescription
		));
	}

}