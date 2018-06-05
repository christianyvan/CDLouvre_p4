<?php

namespace CD\LouvreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TicketDescription
 *
 * @ORM\Table(name="ticket_description")
 * @ORM\Entity(repositoryClass="CD\LouvreBundle\Repository\TicketDescriptionRepository")
 */
class TicketDescription
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
	 * @Assert\Length(min=2,minMessage="Deux caractères minimum")
     * @ORM\Column(name="visitorLastName", type="string", length=255)
     */
    private $visitorLastName;

    /**
     * @var string
     * @Assert\NotBlank()
	 * @Assert\Length(min=2,minMessage="Deux caractères minimum")
     * @ORM\Column(name="visitorFirstName", type="string", length=255)
     */
    private $visitorFirstName;

    /**
     * @var \DateTime
     * @Assert\DateTime()
     * @ORM\Column(name="visitorBirthDate", type="datetime")
     */
    private $visitorBirthDate;

    /**
     * @var string
     * @Assert\Country()
     * @ORM\Column(name="visitorCountry", type="string", length=255)
     */
    private $visitorCountry;

    /**
     * @var bool
     *
     * @ORM\Column(name="reducedPrice", type="boolean")
     */
    private $reducedPrice;

    /**
     * @var int
     *
     * @ORM\Column(name="ticketPrice", type="integer",nullable=true)
	 *
     */
    private $ticketPrice;

	/**
	 * @ORM\ManyToOne(targetEntity="CD\LouvreBundle\Entity\PurchaseOrder", inversedBy="ticketDescription", cascade={"persist"})
	 * @ORM\JoinColumn(name="idresa", referencedColumnName="id")
	 */
	private $purchaseOrder;

	/**
	 * @ORM\Column(name="idresa", type="integer", nullable=true)
	 */
	private $idResa ;

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
     * Set visitorLastName
     *
     * @param string $visitorLastName
     *
     * @return TicketDescription
     */
    public function setVisitorLastName($visitorLastName)
    {
        $this->visitorLastName = $visitorLastName;

        return $this;
    }

    /**
     * Get visitorLastName
     *
     * @return string
     */
    public function getVisitorLastName()
    {
        return $this->visitorLastName;
    }

    /**
     * Set visitorFirstName
     *
     * @param string $visitorFirstName
     *
     * @return TicketDescription
     */
    public function setVisitorFirstName($visitorFirstName)
    {
        $this->visitorFirstName = $visitorFirstName;

        return $this;
    }

    /**
     * Get visitorFirstName
     *
     * @return string
     */
    public function getVisitorFirstName()
    {
        return $this->visitorFirstName;
    }

    /**
     * Set visitorBirthDate
     *
     * @param \DateTime $visitorBirthDate
     *
     * @return TicketDescription
     */
    public function setVisitorBirthDate($visitorBirthDate)
    {
        $this->visitorBirthDate = $visitorBirthDate;

        return $this;
    }

    /**
     * Get visitorBirthDate
     *
     * @return \DateTime
     */
    public function getVisitorBirthDate()
    {
        return $this->visitorBirthDate;
    }

    /**
     * Set visitorCountry
     *
     * @param string $visitorCountry
     *
     * @return TicketDescription
     */
    public function setVisitorCountry($visitorCountry)
    {
        $this->visitorCountry = $visitorCountry;

        return $this;
    }

    /**
     * Get visitorCountry
     *
     * @return string
     */
    public function getVisitorCountry()
    {
        return $this->visitorCountry;
    }

    /**
     * Set reducedPrice
     *
     * @param boolean $reducedPrice
     *
     * @return TicketDescription
     */
    public function setReducedPrice($reducedPrice)
    {
        $this->reducedPrice = $reducedPrice;

        return $this;
    }

    /**
     * Get reducedPrice
     *
     * @return bool
     */
    public function getReducedPrice()
    {
        return $this->reducedPrice;
    }

    /**
     * Set ticketPrice
     *
     * @param integer $ticketPrice
     *
     * @return TicketDescription
     */
    public function setTicketPrice($ticketPrice)
    {
        $this->ticketPrice = $ticketPrice;

        return $this;
    }

    /**
     * Get ticketPrice
     *
     * @return int
     */
    public function getTicketPrice()
    {
        return $this->ticketPrice;
    }

    /**
     * Set idResa
     *
     * @param integer $idResa
     *
     * @return TicketDescription
     */
    public function setIdResa($idResa)
    {
        $this->idResa = $idResa;

        return $this;
    }

    /**
     * Get idResa
     *
     * @return integer
     */
    public function getIdResa()
    {
        return $this->idResa;
    }

    /**
     * Set purchaseOrder
     *
     * @param \CD\LouvreBundle\Entity\PurchaseOrder $purchaseOrder
     *
     * @return TicketDescription
     */
    public function setPurchaseOrder(\CD\LouvreBundle\Entity\PurchaseOrder $purchaseOrder = null)
    {
        $this->purchaseOrder = $purchaseOrder;

        return $this;
    }

    /**
     * Get purchaseOrder
     *
     * @return \CD\LouvreBundle\Entity\PurchaseOrder
     */
    public function getPurchaseOrder()
    {
        return $this->purchaseOrder;
    }
}
