<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ProjectRepository;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ProjectController extends AbstractController
{
    private $repository;
    private $repository_user;
    /**
     * @var Request
     */
    private $request;

    public function __construct(ProjectRepository $property_repo, UserRepository $users)
    {
        $this->repository = $property_repo;
        $this->repository_user = $users;
        $this->request = Request::createFromGlobals();
    }

    /**
     * Liste l'ensemble des projects triés par date de publication pour une page donnée.
     *
     * @Route("/projects/", name="project.index")
     * @Template("XxxYyyBundle:Front/project:index.html.twig")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $projects = $this->repository->findAll(); //On récupère les projects
        return $this->render('project/index.html.twig', [
            'current_menu' => 'projects',
            'projects' => array_reverse($projects),
        ]);
    }


    /**
     * @Route("/project/{slug}" , name="project.show", requirements={"slug"="[a-z0-9\-]*"})
     * @param Project $project
     * @param string $slug
     * @param CommentRepository $commentsRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function show(Project $project, string $slug, CommentRepository $commentsRepository)
    {
        if ($project->getSlug() !== $slug) {

            return $this->redirectToRoute('project.show', [
                'id' => $project->getId(),
                'slug' => $project->getSlug()

            ], 301);
        }

        $comment = new Comment();
        $formComment = $this->createForm(CommentType::class, $comment, [
            'action' => $this->generateUrl('add.comment', array('id' => $project->getId())),

        ]);

        $project = $this->repository->find($project);
        $comments = $commentsRepository->findProjectComment( $project->getId(), 'DESC');

        $commentOptions =  $project->getAllowComment();
        $allowComment= false;
        if( isset($commentOptions)&& array_search('allowComment', $commentOptions) !== null ){
            $allowComment = true;

        }
       // dd($allowComment,$commentValidatingAuto );
        return $this->render('project/show.html.twig', [
            'current_menu' => 'projects',
            'project' => $project,
            //'categories' => $catedories,
            'formComment' => $formComment->createView(),
            'comments' => $comments,
            'allowComment' => $allowComment,

        ]);

    }


}
