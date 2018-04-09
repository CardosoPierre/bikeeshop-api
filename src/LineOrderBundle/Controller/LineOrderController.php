<?php

namespace LineOrderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class LineOrderController extends Controller
{
    /**
     * @Route("/")
     */
    public function getAction()
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('LineOrderBundle:LineOrder')->findAll();
        $data =  $this->get('serializer')->serialize($article, 'json');
        $response = new Response($data);

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/{id}")
     */
    public function getOneAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('LineOrderBundle:LineOrder')->find($id);
        $data =  $this->get('serializer')->serialize($article, 'json');
        $response = new Response($data);

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/delete/{id}")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('LineOrderBundle:LineOrder')->find($id);
        $em->remove($article);
        $em->flush();

        return $this->render('default/delete.html.twig');
    }

}
