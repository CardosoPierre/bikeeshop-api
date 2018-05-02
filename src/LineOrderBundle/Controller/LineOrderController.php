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

        $line = $em->getRepository('LineOrderBundle:LineOrder')->findAll();


        return $line;
    }

    /**
     * @Rest\Get("/{id}")
     * @Rest\View()
     */
    public function getOneLineAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $line= $em->getRepository('LineOrderBundle:LineOrder')->find($id);
        if(empty($line)){
            return new JsonResponse(['message'=> 'line not found'], Response::HTTP_NOT_FOUND);
        }


        return $line;
    }

    /**
     * @Rest\Post("/add")
     */
    public function postLineAction(Request $request)
    {
        $line = new LineOrder();

        $line->setOrder($request->request->get('order'));
        $line->setClient($request->request->get('client'));
        $line->setQuantity($request->request->get('quantity'));

        $em = $this->getDoctrine()->getManager();
        $em ->persist($line);
        $em->flush();


        return new JsonResponse(['message'=>'Line added'], Response::HTTP_CREATED);
    }


    /**
     * @Rest\Delete("/delete/{id}")
     */
    public function deleteLineAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $line = $em->getRepository('LineOrderBundle:LineOrder')->find($id);

        if(empty($line)){
            return new JsonResponse(['message' => "This line doesn't exist"], Response::HTTP_BAD_REQUEST);
        }
        $em->remove($line);
        $em->flush();

        return new JsonResponse(['message'=> "Line deleted"], Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/put/{id}")
     */
    public function putLineAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();

        $line = $em->getRepository('LineOrderBundle:LineOrder')->find($id);
        if(empty($line)){
            return new JsonResponse(['message'=> "Line does not exist"],Response::HTTP_NOT_FOUND);
        }

        $line->setOrder($request->request->get('order'));
        $line->setClient($request->request->get('client'));
        $line->setQuantity($request->request->get('quantity'));
        $em->merge($line);
        $em->flush();


        return new JsonResponse(['message'=>'Line modified'], Response::HTTP_OK);
    }

}
