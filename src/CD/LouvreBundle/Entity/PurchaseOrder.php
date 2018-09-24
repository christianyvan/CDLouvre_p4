<?php

namespace CD\LouvreBundle\Entity;

use DateInterval;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * PurchaseOrder
 *
 * @ORM\Table(name="purchase_order")
 * @ORM\Entity(repositoryClass="CD\LouvreBundle\Repository\PurchaseOrderRepository")
 */
class PurchaseOrder
{
	const MAX_PLACES_PER_DAY = 2;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bool
     * @ORM\Column(name="visitType", type="boolean")
     */
    private $visitType;

	/**
	 * @var string
	 * Assert\DateTime()
	 * @ORM\Column(name="visitDate", type="string")
	 */
    private $visitDate;

    /**
     * @var \DateTime
	 * @Assert\DateTime()
     * @ORM\Column(name="orderDate", type="datetime")
     */
    private $orderDate;

    /**
     * @var string
	 * @Assert\NotBlank(message="Ce champ est obligatoire")
	 * @Assert\Email(message="Cet email n'est pas valide.",checkMX=true)
     * @ORM\Column(name="customerEmail", type="string", length=255)
     */
    private $customerEmail;

    /**
     * @var bool
     *
     * @ORM\Column(name="orderValidation", type="boolean")
     */
    private $orderValidation;

    /**
     * @var int
     * @Assert\Range(min=1,max=15,minMessage="Vous devez commander au moins une place.",maxMessage="Vous ne pouvez pas commander plus de 15 places à la fois.")
     * @ORM\Column(name="numberTicketsDesired", type="integer")
     */
    private $numberTicketsDesired;

    /**
     * @var double
     * @ORM\Column(name="amountOrder", type="decimal", precision=3, scale=0)
	 *
     */
    private $amountOrder;

    /**
     * @var string
     *
     * @ORM\Column(name="reservationCode", type="string", length=255)
     */
    private $reservationCode;

	/**
	 * @ORM\OneToMany (targetEntity="CD\LouvreBundle\Entity\TicketDescription", mappedBy="purchaseOrder", cascade={"persist","remove"})
	 * Assert\Type(type="CDLouvreBundle\Entity\TicketDescription")
	 * @Assert\Valid()
	 */
	private $ticketDescription;


	/**
	 * PurchaseOrder constructor.
	 * @throws \Exception
	 */
	public function __construct()
	{
		$this->orderDate = new \DateTime('NOW');

		//$this->setVisitDate($this->orderDate);
		//$this->visitDate = new \DateTime('NOW');
		$this->visitType = 0;
		$this->amountOrder = 0;
		$this->numberTicketsDesired = 0;
		$this->reservationCode = $this->generateCode(15);
		$this->orderValidation = 0;
		$this->ticketDescription = new ArrayCollection();


	}



	/**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set visitType
     *
     * @param boolean $visitType
     *
     * @return PurchaseOrder
     */
    public function setVisitType($visitType)
    {
        $this->visitType = $visitType;

        return $this;
    }

    /**
     * Get visitType
     *
     * @return bool
     */
    public function getVisitType()
    {
        return $this->visitType;
    }

    /**
     * Set orderDate
     *
     * @param \DateTime $orderDate
     *
     * @return PurchaseOrder
     */
    public function setOrderDate($orderDate)
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    /**
     * Get orderDate
     *
     * @return \DateTime
     */
    public function getOrderDate()
    {
        return $this->orderDate;
    }

    /**
     * Set customerEmail
     *
     * @param string $customerEmail
     *
     * @return PurchaseOrder
     */
    public function setCustomerEmail($customerEmail)
    {
        $this->customerEmail = $customerEmail;

        return $this;
    }

    /**
     * Get customerEmail
     *
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    /**
     * Set orderValidation
     *
     * @param boolean $orderValidation
     *
     * @return PurchaseOrder
     */
    public function setOrderValidation($orderValidation)
    {
        $this->orderValidation = $orderValidation;

        return $this;
    }

    /**
     * Get orderValidation
     *
     * @return bool
     */
    public function getOrderValidation()
    {
        return $this->orderValidation;
    }

    /**
     * Set numberTicketsDesired
     *
     * @param integer $numberTicketsDesired
     *
     * @return PurchaseOrder
     */
    public function setNumberTicketsDesired($numberTicketsDesired)
    {
        $this->numberTicketsDesired = $numberTicketsDesired;

        return $this;
    }

    /**
     * Get numberTicketsDesired
     *
     * @return int
     */
    public function getNumberTicketsDesired()
    {
        return $this->numberTicketsDesired;
    }

    /**
     * Set amountOrder
     *
     * @param string $amountOrder
     *
     * @return PurchaseOrder
     */
    public function setAmountOrder($amountOrder)
    {
        $this->amountOrder = $amountOrder;

        return $this;
    }

    /**
     * Get amountOrder
     *
     * @return string
     */
    public function getAmountOrder()
    {
        return $this->amountOrder;
    }

    /**
     * Set reservationCode
     *
     * @param string $reservationCode
     *
     * @return PurchaseOrder
     */
    public function setReservationCode($reservationCode)
    {
        $this->reservationCode = $reservationCode;

        return $this;
    }

    /**
     * Get reservationCode
     *
     * @return string
     */
    public function getReservationCode()
    {
        return $this->reservationCode;
    }

	/**
	 * generateCode fonction qui génère un code unique pour une commande donnée
	 * @param $length
	 * @return bool|string
	 */
	function generateCode($length)
	{
		$token ="azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN0123456789";
		return substr(str_shuffle(str_repeat($token, $length)),0,$length);
	}

    /**
     * Add ticketDescription
     *
     * @param \CD\LouvreBundle\Entity\TicketDescription $ticketDescription
     *
     * @return PurchaseOrder
     */
    public function addTicketDescription(\CD\LouvreBundle\Entity\TicketDescription $ticketDescription)
    {
        $this->ticketDescription[] = $ticketDescription;

        return $this;
    }

    /**
     * Remove ticketDescription
     *
     * @param \CD\LouvreBundle\Entity\TicketDescription $ticketDescription
     */
    public function removeTicketDescription(\CD\LouvreBundle\Entity\TicketDescription $ticketDescription)
    {
        $this->ticketDescription->removeElement($ticketDescription);
    }

    /**
     * Get ticketDescription
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTicketDescription()
    {
        return $this->ticketDescription;
    }

	/**
	 * fonction qui permet de positionner au jour ouvré suivant le datepicker lorsque le jour courant est un jour de
	 * fermeture
	 * @param $visitDate
	 * @return $this
	 * @throws \Exception
	 */
    public function setVisitDate($visitDate)
    {
    	$this->visitDate = $visitDate;
	/*	$currentDay = date_format($visitDate,'N');
		$visitDateWithoutYear = date_format($visitDate,"m-d");
		//var_dump($visitDateWithoutYear);die('coucou');


       if($currentDay == 2 || $currentDay == 7)
       { 										// 7 pour dimanche et 2 pour mardi
		    $this->visitDate = $visitDate->add(new DateInterval('P1D'));

			return $this;
	   }
	   else if($visitDateWithoutYear == "05-01" ||$visitDateWithoutYear =="11-01" || $visitDateWithoutYear =="12-25")
	   {
		   $this->visitDate = $visitDate->add(new DateInterval('P1D'));
		   return $this;
	   }
	   else{
		   $this->visitDate = $visitDate;
		}*/
		return $this;


    }

    /**
     * Get visitDate
     *
     * @return \DateTime
     */
    public function getVisitDate()
    {
        return $this->visitDate;
    }
}
