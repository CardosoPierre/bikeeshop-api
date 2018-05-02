<?php

namespace ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use ArticleBundle\Entity\Article;
use FOS\RestBundle\Controller\Annotations as Rest;


class ArticleController extends Controller
{
    /**
     * @Rest\View()
     * @Rest\Get("/")
     */
    public function getArticlesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('ArticleBundle:Article')->findAll();

        return $articles;
    }

    /**
     * @Rest\Get("/{id}")
     * @Rest\View()
     */
    public function getOneArticleAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('ArticleBundle:Article')->find($id);
        if (empty($article)) {
            return new JsonResponse(['message' => 'Article not found'], Response::HTTP_NOT_FOUND);
        }

        return $article;
    }

    /**
     * @Rest\Post("/add")
     * @Rest\View()
     *
     */
    public function postArticleAction(Request $request)
    {
        $article = new Article();

        $article->setName($request->request->get('name'));
        $article->setDescription($request->request->get('description'));
        $article->setVisual($request->request->get('visual'));
        $article->setPrice($request->request->get('price'));
        $article->setStock($request->request->get('stock'));
        $article->setCategory($request->request->get('category'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        return new JsonResponse(['message' => 'Article added'], Response::HTTP_CREATED);

    }

    /**
     * @Rest\Delete("/delete/{id}")
     */
    public function deleteArticleAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('ArticleBundle:Article')->find($id);
        if (empty($article)) {
            return new JsonResponse(['message' => "This article doesn't exist"], Response::HTTP_BAD_REQUEST);
        }
        $em->remove($article);
        $em->flush();

        return new JsonResponse(['message' => 'Article deleted'], Response::HTTP_NO_CONTENT);
    }

    /**
     * @Rest\Put("/put/{id}")
     */
    public function putArticleAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('ArticleBundle:Article')->find($id);
        if(empty($article)){
            return new JsonResponse(['message'=> "Article does not exist"],Response::HTTP_NOT_FOUND);
        }
        $article->setName($request->request->get('name'));
        $article->setDescription($request->request->get('description'));
        $article->setVisual($request->request->get('visual'));
        $article->setPrice($request->request->get('price'));
        $article->setStock($request->request->get('stock'));
        $article->setCategory($request->request->get('category'));
        $em->merge($article);
        $em->flush();


        return new JsonResponse(['message'=>'Article modified'], Response::HTTP_OK);
    }
}