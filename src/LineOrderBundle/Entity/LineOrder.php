<?php

namespace LineOrderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LineOrder
 *
 * @ORM\Table(name="line_order")
 * @ORM\Entity(repositoryClass="LineOrderBundle\Repository\LineOrderRepository")
 */
class LineOrder
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @var order
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="OrderBundle\Entity\Orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $order;

    /**
     * @var client
     *
     * @ORM\ManyToOne(targetEntity="ClientBundle\Entity\Client")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;


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
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return LineOrder
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function setClient($client)
    {
         $this->client = $client;

         return $this;

    }

    public function getOrder()
    {
        return $this->order;
    }

    public function setOrder($order)
    {
        $this->order=$order;

        return $this;
    }
}

