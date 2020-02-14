<?php

namespace App\Controller;


use App\Form\ContactType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request, \Swift_Mailer $mailer,ProjectRepository $projectRepo)
    {
        $favoriteProjects = $projectRepo->findFavorite();
        $projects = $projectRepo->findAllExecptFavorite();
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();

            $message = (new \Swift_Message('Une personne contact l\'agence ! '))
                ->setFrom($contactFormData['fromEmail'])
                ->setTo('said.ladghem@gmail.com')

                ->setBody(
                    $this->renderView(
                    // templates/emails/registration.html.twig
                        '/emails/contact.html.twig',
                        [
                            'name' => $contactFormData['fullName'],
                            'mail' => $contactFormData['fromEmail'],
                            'message' => $contactFormData['message']
                            ]
                    ),
                    'text/html'
                )

            ;

            $mailer->send($message);

            $this->addFlash('success', 'Message was sent');

            return $this->redirectToRoute('index');
        }

        //dd($treeLastProjects);
        return $this->render('index.html.twig', [
            'formContact' => $form->createView(),
            'favoriteProjects' => $favoriteProjects,
            'projects' => $projects,
        ]);
    }

    /**
     * @Route("/service", name="service.index")
     */
    public function showService()
    {
        return $this->render('/service/index.html.twig', [
            "current_menu" => "service"
        ]);
    }


    /**
     * @Route("/about", name="about")
     */
    public function showAbout()
    {
        return $this->render('/about/about.html.twig', [
            "current_menu" => "about"
        ]);
    }

}
