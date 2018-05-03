<?php

namespace OrderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use OrderBundle\Entity\Orders;
use FOS\RestBundle\Controller\Annotations as Rest;

class OrderController extends Controller
{
    /**
     * @Rest\Get("/")
     * @Rest\View()
     */
    public function getOrdersAction()
    {
        $em = $this->getDoctrine()->getManager();

        $order = $em->getRepository('OrderBundle:Orders')->findAll();


        return $order;
    }

    /**
     * @Rest\Get("/{id}")
     * @Rest\View()
     */
    public function getOneOrderAction(Orders $order = null)
    {
        if ($order == null){
            return new JsonResponse(['message'=> 'order not found'], Response::HTTP_NOT_FOUND);
        }

        return $order;
    }

    /**
     * @Rest\Get("/{id}/lines")
     * @Rest\View()
     */
    public function getLineOrderAction(Orders $order = null)
    {
        if ($order == null){
            return new JsonResponse(['message'=> 'order not found'], Response::HTTP_NOT_FOUND);
        }

        return $order->getLineOrders();
    }

    /**
     * @Rest\Post("/add")
     * @Rest\View()
     *
     */
    public function postOrderAction(Request $request)
    {
        $order = new Orders();

        $em = $this->getDoctrine()->getManager();

        $client = $em
            ->getRepository("ClientBundle:Client")
            ->find($request->request->get('client'));

        $order->setClient($client);

        $em->persist($order);
        $em->flush();

        return new JsonResponse(['message'=> 'Order added'], Response::HTTP_CREATED);

    }

    /**
     * @Rest\Delete("/delete/{id}")
     */
    public function deleteOrderAction(Orders $order = null)
    {
        if($order == null){
            return new JsonResponse(['message'=> "Order doesn't exist"],Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($order);
        $em->flush();

        return new JsonResponse(['message'=> 'Order deleted'], Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/put/{id}")
     */
    public function putOrderAction(Request $request,Orders $order = null)
    {
        if($order == null){
            return new JsonResponse(['message'=> "Order does not exist"],Response::HTTP_NOT_FOUND);
        }

        $em = $this->getDoctrine()->getManager();
        $order->setClient($request->request->get('client'));
        $em->merge($order);
        $em->flush();


        return new JsonResponse(['message'=>'Order modified'], Response::HTTP_OK);
    }


}
