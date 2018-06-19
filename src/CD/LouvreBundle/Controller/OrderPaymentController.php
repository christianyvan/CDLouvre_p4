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
	/**
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 * @throws \Exception
	 */
	public function paymentStripeAction(Request $request)
	{

		\Stripe\Stripe::setApiKey("sk_test_6bsPGo1gZmnZGtkvdl6lbqbC");

		$em = $this->getDoctrine()->getManager();

		// Récupération des élements de paiement
		$token = $request->request->get('stripeToken');

		$email = $request->request->get('stripeEmail'); // Récupérée depuis Stripe

		$amount = $request->request->get('amount');
		$id = $request->request->get('idRes');
		//var_dump($id);die('valeur id');

		// Créer une charge: cela permettra de facturer la carte de l'utilisateur
		try {
			$charge = \Stripe\Charge::create(array(
				"amount" => $amount * 100, // Montant en centimes
				"currency" => "eur",
				"source" => $token,
				"description" => 'Paiement Stripe de : '. $amount . '€ pour la commande de l\'adresse Email : ' . $email
			));

			// Mise à jour du Montant total de la réservation
			$purchaseOrder = $em->getRepository('CDLouvreBundle:PurchaseOrder')->find($id);

			$purchaseOrder->setOrderValidation(true);
			$em->persist($purchaseOrder);
			$em->flush();

			return $this->redirectToRoute('louvre_sendMail', array('code' =>$purchaseOrder->getReservationCode()));

		} catch(\Stripe\Error\Card $e) {
			$id = $request->request->get('idRes');

			// Si le paiement est refusé , on redirige vers la page paymentDeclined via la méthode paymentDeclined
			// du controller OrderPaymentController
			return $this->redirectToRoute('louvre_paymentDeclined',array('id'=> $id/*$purchaseOrder->getId()*/));

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
			->attach(\Swift_Attachment::fromPath('images/louvre.jpg')->setDisposition('inline'))
			->setBody($this->renderView('CDLouvreBundle:Email:email.html.twig', array(
				'purchaseOrder'   	  =>$purchaseOrder,
				'ticketsDescription'   =>$ticketsDescription

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


	public function paymentDeclinedAction($id){

		$em = $this->getDoctrine()->getManager();
		$purchaseOrder = $this->getDoctrine()
			->getManager()
			->getRepository('CDLouvreBundle:PurchaseOrder')
			->find($id);
		$ticketsDescription = $purchaseOrder->getTicketDescription();
		// on supprime la commande dont le paiement a été refusé de la bdd
		$em->remove($purchaseOrder);
		$em->flush();
		return $this->render('CDLouvreBundle:OrderPayment:paymentDeclined.html.twig', array(
			'purchaseOrder'			 => $purchaseOrder,
			'ticketsDescription'	 => $ticketsDescription
		));
	}

}