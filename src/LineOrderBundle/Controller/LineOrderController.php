<?php

namespace LineOrderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use LineOrderBundle\Entity\LineOrder;
use FOS\RestBundle\Controller\Annotations as Rest;

class LineOrderController extends Controller
{
    /**
     * @Rest\Get("/")
     * @Rest\View()
     */
    public function getLinesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $lineOrders = $em->getRepository('LineOrderBundle:LineOrder')->findAll();


        return $lineOrders;
    }

    /**
     * @Rest\Get("/{id}")
     * @Rest\View()
     */
    public function getOneLineAction(LineOrder $lineOrder = null)
    {
        if ($lineOrder == null){
            return new JsonResponse(['message'=> 'line not found'], Response::HTTP_NOT_FOUND);
        }

        return $lineOrder;
    }

    /**
     * @Rest\Post("/add")
     */
    public function postLineAction(Request $request)
    {
        $lineOrder = new LineOrder();

        $em = $this->getDoctrine()->getManager();

        $order = $em
            ->getRepository("OrderBundle:Orders")
            ->find($request->request->get('order'));
        $lineOrder->setOrder($order);

        $article = $em
            ->getRepository("ArticleBundle:Article")
            ->find($request->request->get('article'));
        $lineOrder->setArticle($article);

        $lineOrder->setQuantity($request->request->get('quantity'));

        $em ->persist($lineOrder);
        $em->flush();

        return new JsonResponse(['message'=>'Line added'], Response::HTTP_CREATED);
    }


    /**
     * @Rest\Delete("/delete/{id}")
     */
    public function deleteLineAction(LineOrder $lineOrder = null)
    {
        if($lineOrder == null){
            return new JsonResponse(['message' => "This line doesn't exist"], Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($lineOrder);
        $em->flush();

        return new JsonResponse(['message'=> "Line deleted"], Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/put/{id}")
     */
    public function putLineAction(Request $request,LineOrder $lineOrder = null)
    {
        if(empty($lineOrder)){
            return new JsonResponse(['message'=> "Line does not exist"],Response::HTTP_NOT_FOUND);
        }

        $em = $this->getDoctrine()->getManager();
        $order = $em
            ->getRepository("OrderBundle:Orders")
            ->find($request->request->get('order'));
        $lineOrder->setOrder($order);

        $article = $em
            ->getRepository("ArticleBundle:Article")
            ->find($request->request->get('article'));
        $lineOrder->setArticle($article);
        $lineOrder->setQuantity($request->request->get('quantity'));
        $em->merge($lineOrder);
        $em->flush();

        return new JsonResponse(['message'=>'Line modified'], Response::HTTP_OK);
    }

}
