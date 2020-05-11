<?php

namespace App\Infrastructure\Http\Rest\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Domain\Model\Article\Article;
use App\Application\Service\ArticleService;
use App\Infrastructure\Repository\ArticleRepository;

/**
 * Class ArticleController
 *
 * @package App\Infrastructure\Http\Rest\Controller
 */
final class ArticleController extends AbstractFOSRestController
{
    /**
     * @var ArticleService
     */
    private $articleService;

    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * ArticleController constructor.
     *
     * @param ArticleService $articleService
     * @param ArticleRepository $articleRepository
     */
    public function __construct(ArticleService $articleService, ArticleRepository $articleRepository)
    {
        $this->articleService = $articleService;
        $this->articleRepository = $articleRepository;
    }

    /**
     * Creates an Article resource
     * @Rest\Post("/articles")
     *
     * @param Request $request
     *
     * @return View
     */
    public function postArticle(Request $request): View
    {
        $article = new Article();
        $article->setTitle($request->get('title'));
        $article->setContent($request->get('content'));
        $this->articleRepository->save($article);

        // In case our POST was a success we need to return a 201 HTTP CREATED response
        return View::create($article, Response::HTTP_CREATED);
    }

    /**
     * Retrieves an Article resource
     * @Rest\Get("/articles/{articleId}")
     *
     * @param int $articleId
     *
     * @return View
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function getArticle(int $articleId): View
    {
        $article = $this->articleService->getArticle($articleId);

        // In case our GET was a success we need to return a 200 HTTP OK response with the request object
        return View::create($article, Response::HTTP_OK);
    }

    /**
     * Retrieves a collection of Article resource
     * @Rest\Get("/articles")
     *
     * @return View
     */
    public function getArticles(): View
    {
        $articles = $this->articleService->getAllArticles();

        // In case our GET was a success we need to return a 200 HTTP OK response with the collection of article object
        return View::create($articles, Response::HTTP_OK);
    }

    /**
     * Replaces Article resource
     * @Rest\Put("/articles/{articleId}")
     *
     * @param int $articleId
     *
     * @return View
     */
    public function putArticle(int $articleId, Request $request): View
    {
        $article = $this->articleRepository->findById($articleId);
        if ($article) {
            $article->setTitle($request->get('title'));
            $article->setContent($request->get('content'));
            $this->articleRepository->save($article);
        }

        // In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
        return View::create($article, Response::HTTP_OK);
    }

    /**
     * Removes the Article resource
     * @Rest\Delete("/articles/{articleId}")
     *
     * @param int $articleId
     *
     * @return View
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function deleteArticle(int $articleId): View
    {
        $this->articleService->deleteArticle($articleId);

        // In case our DELETE was a success we need to return a 204 HTTP NO CONTENT response. The object is deleted.
        return View::create([], Response::HTTP_NO_CONTENT);
    }
}
