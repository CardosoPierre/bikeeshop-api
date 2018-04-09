<?php

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends Controller
{
    /**
     * @Route("/")
     */
    public function getAction()
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('ClientBundle:Client')->findAll();
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

        $article = $em->getRepository('ClientBundle:Client')->find($id);
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

        $article = $em->getRepository('ClientBundle:Bundle')->find($id);
        $em->remove($article);
        $em->flush();

        return $this->render('default/delete.html.twig');
    }


}
