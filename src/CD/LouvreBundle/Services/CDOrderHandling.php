<?php
/**
 * Created by PhpStorm.
 * User: Christian
 * Date: 16/05/2018
 * Time: 12:36
 */

namespace CD\LouvreBundle\Services;
use Doctrine\ORM\EntityManager;
use CD\LouvreBundle\Entity\PurchaseOrder;


class CDOrderHandling
{

// Récupération du nombre de billets Max par jour via
// le parametre mis dans le fichier app/config/parameters.yml
	const  MAX_PLACES_PER_DAY = 15 ;
	private $maxPlacesPerDay;

// Utilisation d'EntityManager dans les méthodes de la class CDOrderHandling
	private $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
		$this->maxPlacesPerDay = self::MAX_PLACES_PER_DAY;

	}

	// Calcul du nombre de place restant disponible pour la vente
	public function getNumberOfPlacesAvailable($placesRequested)
	{
		$places = $this-> maxPlacesPerDay  - $placesRequested;
		return $places;
	}

	// Calcul du prix du billet en fonction de la date de naissance du visiteur, du type de visite (journée,demi-journée
	// si il bénéficie d'un tarif réduit
	public function  getPrice($visitorBirthDate, $reducePrice, $visitType)
	{
		$currentDate = new \DateTime();
		$current_year = $currentDate->format('Y');
		$visitor_year = $visitorBirthDate;
		$age = $current_year - $visitor_year;


		if ($age < 4)
		{
			$price = 0;          // tarif gratuit visiteur de moins de 4 ans
			return $price;
		}


		if($reducePrice == 0)
		{
			if ($age >= 12 && $age < 60)
			{
				if ($visitType == 1)
				{
					$price = 16;    //tarif normal à la journée à partir de 12 ans
					return $price;
				}
				else
				{
					$price = 8;     // tarif normal à la demi-journée à partir de 12 ans
					return $price;
				}
			}

			elseif ($age >= 4 && $age < 12)
			{
				if ($visitType == 1)
				{
					$price = 8;         // tarif enfant à la journée de 4ans inclus à 12 ans exlus
					return $price;
				}
				else
				{
					$price = 4;        // tarif enfant à la demi-journée de 4 ans inclus à 12 ans exclus
					return $price;
				}
			}

			elseif ($age >= 60)
			{
				if ($visitType == 1)
				{
					$price = 12;        // tarif sénior à la journée à partir de 60 ans inclus
					return $price;
				}
				else
				{
					$price = 6;        // tarif sénior à la demi-journéé à partir de 60 ans inclus
					return $price;
				}
			}
		}

		if($reducePrice == 1)
		{
			if ($visitType == 0)
			{
				$price=5;
				return $price;
			}
			else
			{
				$price=10;
				return $price;
			}
		}

	}

	// fonction qui renvoi le montant totale de la commande en fonction des valeurs renseignées à partir du formulaire
	public function setOrderAmount(PurchaseOrder $purchaseOrder,$ticketsDescription)
	{

		$amountOrder = 0;
		foreach ($ticketsDescription as $key => $value) {
			// on affecte l'id de la commande à l' idResa de la description du ticket
			$ticketsDescription[$key]->setIdResa($purchaseOrder->getId());

			// on récupère le type de la visite (journée, demi-journée)
			$visitType = $purchaseOrder->getVisitType();

			// on récupère la date de naissance du visiteur
			$birthDate = $ticketsDescription[$key]->getVisitorBirthDate();

			// on récupère l'année de la date de naissance
			$birthYear = $birthDate->format('Y');

			// on récupère la valeur de  tarif réduit
			$reducedPrice = $ticketsDescription[$key]->getReducedPrice();

			// on renseigne le prix du ticket pour l'entité IicketDescription
			$ticketsDescription[$key]->setTicketPrice($this->getPrice($birthYear,$reducedPrice,$visitType));

			// on ajoute le prix de chaque ticket renseigné à la ligne au dessus à la variable $amountOrder
			$amountOrder += $ticketsDescription[$key]->getTicketPrice();

			// on persiste les modifications dans la boucle puis on les flusches en dehors de la boucle
			$this->em->persist($ticketsDescription[$key]);
		}
		$this->em->flush();
		// on retourne le montant total de la commande
		return $amountOrder;
	}

	public function updateIdTicketsDescription($purchaseOrder,$ticketsDescription)
	{

		foreach ($ticketsDescription as $key=>$value)
		{
			$ticketsDescription[$key]->setIdResa($purchaseOrder->getId());
			$this->em->persist($ticketsDescription[$key]);
		}
		$this->em->flush();

	}

}