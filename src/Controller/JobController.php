<?php

namespace App\Controller;

use App\Entity\Job;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\JobRepository;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use Msalsas\VotingBundle\Service\Voter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class JobController extends AbstractController
{
    private $repository;
    private $repository_user;
    /**
     * @var Request
     */
    private $request;

    public function __construct(JobRepository $property_repo, UserRepository $users)
    {
        $this->repository = $property_repo;
        $this->repository_user = $users;
        $this->request = Request::createFromGlobals();
    }

    /**
     * Liste l'ensemble des jobs triés par date de publication pour une page donnée.
     *
     * @Route("/jobs/", name="job.index")
     * @Template("XxxYyyBundle:Front/job:index.html.twig")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $jobs = $this->repository->findAll(); //On récupère les jobs
        return $this->render('job/index.html.twig', [
            'current_menu' => 'jobs',
            'jobs' => $jobs,
        ]);
    }

    
    /**
     * @Route("/job/{slug}/{id}" , name="job.show", requirements={"id"="\d+","slug"="[a-z0-9\-]*"})
     * @param Job $job
     * @param string $slug
     * @param CommentRepository $commentsRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function show(Job $job, string $slug, CommentRepository $commentsRepository)
    {
        if ($job->getSlug() !== $slug) {

            return $this->redirectToRoute('job.show', [
                'id' => $job->getId(),
                'slug' => $job->getSlug()

            ], 301);
        }

        $comment = new Comment();
        $formComment = $this->createForm(CommentType::class, $comment, [
            'action' => $this->generateUrl('add.comment', array('job' => $job->getId())),
        ]);





        $job = $this->repository->find($job);
        $comments = $commentsRepository->findBy(
            array('job' => $job->getId()),
            array('created_at' => 'DESC'));
        //dd($comments);
        //$catedories = job::CATEGORIE;

        return $this->render('job/show.html.twig', [
            'current_menu' => 'jobs',
            'job' => $job,
            //'categories' => $catedories,
            'formComment' => $formComment->createView(),
            'comments' => $comments

        ]);

    }

    
}
