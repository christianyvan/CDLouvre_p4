<?php

namespace CD\LouvreBundle\Entity;

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
	const MAX_PLACES_PER_DAY = 10;

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
	 * @var \DateTime
	 * @Assert\DateTime()
	 * @ORM\Column(name="visitDate", type="datetime")
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
	 * @Assert\NotBlank()
	 * @Assert\Email(message="Cet email est invalide.",checkMX=true)
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
     */
    private $amountOrder;

    /**
     * @var string
     *
     * @ORM\Column(name="reservationCode", type="string", length=255)
     */
    private $reservationCode;

	/**
	 * @ORM\OneToMany (targetEntity="CD\LouvreBundle\Entity\TicketDescription", mappedBy="purchaseOrder", cascade={"persist"})
	 * Assert\Type(type="CDLouvreBundle\Entity\TicketDescription")
	 * @Assert\Valid()
	 */
	private $ticketDescription;



	public function __construct()
	{
		$this->orderDate = new \DateTime('NOW');
		$this->visitDate = new \DateTime();
		$this->visitType = 0;
		$this->amountOrder = 0;
		$this->numberTicketsDesired = 1;
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
     * Set visitDate
     *
     * @param \DateTime $visitDate
     *
     * @return PurchaseOrder
     */
    public function setVisitDate($visitDate)
    {
        $this->visitDate = $visitDate;

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
