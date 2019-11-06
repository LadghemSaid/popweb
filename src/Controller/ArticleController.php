<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use Msalsas\VotingBundle\Service\Voter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ArticleController extends AbstractController
{
    private $repository;
    private $repository_user;
    /**
     * @var Request
     */
    private $request;

    public function __construct(ArticleRepository $property_repo, UserRepository $users)
    {
        $this->repository = $property_repo;
        $this->repository_user = $users;
        $this->request = Request::createFromGlobals();
    }

    /**
     * Liste l'ensemble des articles triés par date de publication pour une page donnée.
     *
     * @Route("/articles/", name="article.index")
     * @Template("XxxYyyBundle:Front/Article:index.html.twig")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $articles = $this->repository->findAll(); //On récupère les articles
        return $this->render('article/index.html.twig', [
            'current_menu' => 'articles',
            'articles' => $articles,
            'articles' => $articles,
        ]);
    }

    
    /**
     * @Route("/article/{slug}/{id}" , name="article.show", requirements={"id"="\d+","slug"="[a-z0-9\-]*"})
     * @param Article $article
     * @param string $slug
     * @param CommentRepository $commentsRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function show(Article $article, string $slug, CommentRepository $commentsRepository)
    {
        if ($article->getSlug() !== $slug) {

            return $this->redirectToRoute('article.show', [
                'id' => $article->getId(),
                'slug' => $article->getSlug()

            ], 301);
        }

        $comment = new Comment();
        $formComment = $this->createForm(CommentType::class, $comment, [
            'action' => $this->generateUrl('add.comment', array('article' => $article->getId())),
        ]);





        $article = $this->repository->find($article);
        $comments = $commentsRepository->findBy(
            array('article' => $article->getId()),
            array('created_at' => 'DESC'));
        //dd($comments);
        //$catedories = Article::CATEGORIE;

        return $this->render('article/show.html.twig', [
            'current_menu' => 'articles',
            'article' => $article,
            //'categories' => $catedories,
            'formComment' => $formComment->createView(),
            'comments' => $comments

        ]);

    }

    
}
