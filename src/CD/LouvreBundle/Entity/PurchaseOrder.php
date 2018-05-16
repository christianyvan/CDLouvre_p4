<?php

namespace CD\LouvreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PurchaseOrder
 *
 * @ORM\Table(name="purchase_order")
 * @ORM\Entity(repositoryClass="CD\LouvreBundle\Repository\PurchaseOrderRepository")
 */
class PurchaseOrder
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
     * @var bool
     *
     * @ORM\Column(name="visitType", type="boolean")
     */
    private $visitType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="orderDate", type="datetime")
     */
    private $orderDate;

    /**
     * @var string
     *
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
     *
     * @ORM\Column(name="numberTicketsDesired", type="integer")
     */
    private $numberTicketsDesired;

    /**
     * @var string
     *
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
}

