<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class CommentsController extends AbstractController
{
    /**
     * @Route("/add/comment/{article}", name="add.comment", methods={"POST"})
     * @param Request $req
     * @param Security $security
     * @param $articleid
     * @param ArticleRepository $articleRepo
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function add(Request $req, Security $security, $article, ArticleRepository $articleRepo)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {

            $article2= $articleRepo->find($article);
            $com = $form->getData();

            $com->setUser($security->getUser())
                ->setArticle($article2)
                ->setCreatedAt(new \DateTime())
                ->setApproved(true);
            //dd($com);
            $em =  $this->getDoctrine()->getManager();
            $em->persist($com);
            $em->flush();

            return $this->redirectToRoute('article.show', array('slug'=>$article2->getSlug(),'id'=>$article));

        }
    }

    /**
     * @Route("/delete/comment/{comment}", name="delete.comment", methods={"GET"})
     */
    public function delete(Comment $comment, Security $security)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if($security->getUser() === $comment->getUser()){
            $article = $comment->getArticle();
            $em =  $this->getDoctrine()->getManager();
            $em->remove($comment);
            $em->flush();
        }
        return $this->redirectToRoute('article.show', array('slug'=>$article->getSlug(),'id'=>$article->getId()));

        //dd($comment);

    }

    /**
     * @Route("/comment/edit/{comment}", name="comment_edit")
     */
    public function edit(Comment $comment,Request $request){

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
           // dd($form);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setTextComment($form["textComment"]->getData());
            $em =  $this->getDoctrine()->getManager();
            $em->flush();

        }
        return new Response;
    }

}
