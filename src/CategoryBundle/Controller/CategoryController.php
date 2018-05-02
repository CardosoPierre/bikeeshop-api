<?php

namespace CategoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use CategoryBundle\Entity\Category;
use FOS\RestBundle\Controller\Annotations as Rest;


class CategoryController extends Controller
{
    /**
     * @Rest\Get("/")
     * @Rest\View()
     */
    public function getCategorysAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categorys = $em->getRepository('CategoryBundle:Category')->findAll();


        return $categorys;
    }

    /**
     * @Rest\Get("/{id}")
     * @Rest\View()
     */
    public function getOneCategoryAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('CategoryBundle:Category')->find($id);
        if(empty($category)){
            return new JsonResponse(['message'=> 'Category not found'], Response::HTTP_NOT_FOUND);
        }


        return $category;
    }

    /**
     * @Rest\Post("/add")
     * @Rest\View()
     */
    public function postCategoryAction(Request $request)
    {

        $category = new Category();

        $category->setName($request->request->get('name'));
        $category->setDescription($request->request->get('description'));
        $category->setVisual($request->request->get('visual'));


        $em = $this->getDoctrine()->getManager();
        $em ->persist($category);
        $em->flush();


        return new JsonResponse(['message'=> "Category added"],Response::HTTP_CREATED);
    }


    /**
     * @Rest\Delete("/delete/{id}")
     */
    public function deleteCategoryAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('CategoryBundle:Category')->find($id);
        if(empty($category)){
            return new JsonResponse(['message'=> "This category doesn't exist"], Response::HTTP_BAD_REQUEST);
        }
        $em->remove($category);
        $em->flush();

        return new JsonResponse(['message'=> 'Category deleted'], Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/put/{id}")
     */
    public function putCategoryAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('CategoryBundle:Category')->find($id);
        if(empty($client)){
            return new JsonResponse(['message'=> "Category does not exist"],Response::HTTP_NOT_FOUND);
        }

        $category->setName($request->request->get('name'));
        $category->setDescription($request->request->get('description'));
        $category->setVisual($request->request->get('visual'));
        $em->merge($category);

        return new JsonResponse(['message'=>'Category modified'], Response::HTTP_OK);
    }

}
