<?php

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Tests\Compiler\J;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use ClientBundle\Entity\Client;
use FOS\RestBundle\Controller\Annotations as Rest;
class ClientController extends Controller
{
    /**
     * @Rest\Get("/")
     * @Rest\View()
     */
    public function getClientsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $clients = $em->getRepository('ClientBundle:Client')->findAll();


        return $clients;
    }
    /**
     * @Rest\Get("/get/{id}")
     * @Rest\View()
     */
    public function getOneClientAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $client = $em->getRepository('ClientBundle:Client')->find($id);
        if(empty($client))
        {
            return new JsonResponse(['Message'=> 'Client not found'],Response::HTTP_NOT_FOUND);
        }


        return $client;
    }

    /**
     * @Rest\Post("/add")
     */
    public function postClientAction(Request $request)
    {

        $client = new Client();

        $client->setLastName($request->get('lastName'));
        $client->setFirstName($request->get('firstName'));
        $client->setAddress($request->get('address'));
        $client->setZipCode($request->get('zipCode'));
        $client->setCity($request->get('city'));
        $client->setEmail($request->get('email'));
        $client->setPhone($request->get('phone'));

        $em = $this->getDoctrine()->getManager();
        $em ->persist($client);
        $em->flush();


        return new JsonResponse(['message' => 'Client added'], Response::HTTP_CREATED);
    }

    /**
     * @Rest\Delete("/delete/{id}")
     */
    public function deleteClientAction($id)
    {
        $em = $this->getDoctrine()->getManager();


        $client = $em->getRepository('ClientBundle:Client')->find($id);
        if(empty($client)){
            return new JsonResponse(['message'=> "This client doesn't exist"], Response::HTTP_BAD_REQUEST);
        }
        $em->remove($client);
        $em->flush();

        return new JsonResponse(['message'=>'Client deleted'], Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/put/{id}")
     */
    public function putClientAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();

        $client = $em->getRepository('ClientBundle:Client')->find($id);
        if(empty($client)){
            return new JsonResponse(['message'=> "Client does not exist"],Response::HTTP_NOT_FOUND);
        }
        $client->setLastName($request->get('lastName'));
        $client->setFirstName($request->get('firstName'));
        $client->setAddress($request->get('address'));
        $client->setZipCode($request->get('zipCode'));
        $client->setCity($request->get('city'));
        $client->setEmail($request->get('email'));
        $client->setPhone($request->get('phone'));
        $em->merge($client);
        $em->flush();

            return new JsonResponse(['message'=>'Client modified'], Response::HTTP_OK);




    }


}
