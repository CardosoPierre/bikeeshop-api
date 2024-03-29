<?php

namespace OrderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Orders
 *
 * @ORM\Table(name="orders")
 * @ORM\Entity(repositoryClass="OrderBundle\Repository\OrdersRepository")
 *
 * @Serializer\ExclusionPolicy("ALL")
 */
class Orders
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Expose
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     *
     * @Serializer\Expose
     */
    private $date;

    /**
     * @var client
     *
     * @ORM\ManyToOne(targetEntity="ClientBundle\Entity\Client")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Serializer\Expose
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity="LineOrderBundle\Entity\LineOrder", mappedBy="order")
     */
    private $lineOrders;

    public function __construct()
    {
        $this->date = new \DateTime();
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Orders
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    public function setClient($client)
    {
        $this->client=$client;

        return $this;
    }

    public function getClient()
    {
        return $this->client;
    }

    /**
     * Add lineOrder.
     *
     * @param \LineOrderBundle\Entity\LineOrder $lineOrder
     *
     * @return Orders
     */
    public function addLineOrder(\LineOrderBundle\Entity\LineOrder $lineOrder)
    {
        $this->lineOrders[] = $lineOrder;

        return $this;
    }

    /**
     * Remove lineOrder.
     *
     * @param \LineOrderBundle\Entity\LineOrder $lineOrder
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeLineOrder(\LineOrderBundle\Entity\LineOrder $lineOrder)
    {
        return $this->lineOrders->removeElement($lineOrder);
    }

    /**
     * Get lineOrders.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLineOrders()
    {
        return $this->lineOrders;
    }
}
