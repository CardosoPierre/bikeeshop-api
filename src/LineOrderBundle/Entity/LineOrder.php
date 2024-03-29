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
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var order
     *
     * @ORM\ManyToOne(targetEntity="OrderBundle\Entity\Orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $order;

    /**
     * @var article
     *
     * @ORM\ManyToOne(targetEntity="ArticleBundle\Entity\Article")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

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

    public function getOrder()
    {
        return $this->order;
    }

    public function setOrder($order)
    {
        $this->order=$order;

        return $this;
    }

    /**
     * Set id.
     *
     * @param int $id
     *
     * @return LineOrder
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set article.
     *
     * @param \ArticleBundle\Entity\Article $article
     *
     * @return LineOrder
     */
    public function setArticle(\ArticleBundle\Entity\Article $article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article.
     *
     * @return \ArticleBundle\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }
}
