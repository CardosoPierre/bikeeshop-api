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
    public function getOneArticleAction(Article $article = null)
    {
        if ($article == null) {
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
        $em = $this->getDoctrine()->getManager();
        $category = $em
            ->getRepository("CategoryBundle:Category")
            ->find($request->request->get('category'));
        $article->setCategory($category);

        $em->persist($article);
        $em->flush();

        return new JsonResponse(['message' => 'Article added'], Response::HTTP_CREATED);

    }

    /**
     * @Rest\Delete("/delete/{id}")
     */
    public function deleteArticleAction(Article $article = null)
    {
        if ($article == null) {
            return new JsonResponse(['message' => "This article doesn't exist"], Response::HTTP_BAD_REQUEST);
        }
        $em = $this
            ->getDoctrine()
            ->getManager();

        $em->remove($article);
        $em->flush();

        return new JsonResponse(['message' => 'Article deleted'], Response::HTTP_NO_CONTENT);
    }

    /**
     * @Rest\Put("/put/{id}")
     */
    public function putArticleAction(Article $article = null, Request $request)
    {
        if($article == null){
            return new JsonResponse(['message'=> "Article does not exist"],Response::HTTP_NOT_FOUND);
        }

        $em = $this
            ->getDoctrine()
            ->getManager();
        $article->setName($request->request->get('name'));
        $article->setDescription($request->request->get('description'));
        $article->setVisual($request->request->get('visual'));
        $article->setPrice($request->request->get('price'));
        $article->setStock($request->request->get('stock'));
        $category = $em
            ->getRepository("CategoryBundle:Category")
            ->find($request->request->get('category'));
        $article->setCategory($category);
        $em->merge($article);
        $em->flush();


        return new JsonResponse(['message'=>'Article modified'], Response::HTTP_OK);
    }
}