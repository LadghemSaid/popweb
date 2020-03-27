<?php

namespace App\Controller;


use App\Form\ContactType;
use App\Repository\ArticleRepository;
use App\Repository\JobRepository;
use App\Repository\MaillingListRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request, ProjectRepository $projectRepo)
    {
        $favoriteProjects = $projectRepo->findFavorite();
        $projects = $projectRepo->findAllExecptFavorite();


        //dd($treeLastProjects);
        return $this->render('index.html.twig', [
            'favoriteProjects' => $favoriteProjects,
            'projects' => $projects,
        ]);
    }

    /**
     * @Route("/services", name="service.index")
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

    /**
     * @Route("/contact", name="contact.show")
     */
    public function showContact(Request $request, \Swift_Mailer $mailer, MaillingListRepository $mailRepo)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();
            $poolEmail = [
                'said.ladghem@gmail.com',
                'contact.popweb@gmail.com',
                'leatraccoen@outlook.Fr',
                'lison.dagostini@gmail.com',
                'thomas.vinet60490@gmail.com',
                'cloelh@outlook.fr',
                'lacroixlucas59@gmail.com',
            ];

            $poolEmail = $mailRepo->findBy(array('contactMail' => true));
            $newPoolEmail=[];
            foreach ($poolEmail as $email)
            {
                array_push($newPoolEmail, $email->getMail());
            }

            $message = (new \Swift_Message('Une personne contact l\'agence ! '))
                ->setFrom($contactFormData['fromEmail'])
                ->setTo($newPoolEmail)
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
                );

            $mailer->send($message);


            $this->addFlash('success', 'Nous avons bien recu votre demande ! à bientot');

            return $this->redirectToRoute('contact.show');
        }

        return $this->render('/contact/show.html.twig', [
            "current_menu" => "contact",
            'formContact' => $form->createView(),

        ]);
    }

    /**
     * @Route("/sitemaps.xml", name="sitemap")
     */
    public function sitemap(Request $request, ArticleRepository $articleRepository, ProjectRepository $projectRepository, JobRepository $jobRepository)
    {
        $urls = [];
        // We store the hostname of our website
        $hostname = $request->getHost();

        //$urls[] = ['loc' => $this->get('router')->generate('mywebsite_homepage'), 'changefreq' => 'weekly', 'priority' => '1.0'];
        //$urls[] = ['loc' => $this->get('router')->generate('mywebsite_blog'), 'changefreq' => 'weekly', 'priority' => '1.0'];


        $articles = $articleRepository->findAll();
        $projects = $projectRepository->findAll();
        $jobs = $jobRepository->findAll();

        foreach ($articles as $article) {
            $urls[] = ['loc' => $this->get('router')->generate('article.show', ['slug' => $article->getSlug()]), 'changefreq' => 'weekly', 'priority' => '1.0'];
        }

        foreach ($projects as $project) {
            $urls[] = ['loc' => $this->get('router')->generate('project.show', ['slug' => $project->getSlug()]), 'changefreq' => 'weekly', 'priority' => '1.0'];
        }

        foreach ($jobs as $job) {
            $urls[] = ['loc' => $this->get('router')->generate('job.show', ['slug' => $job->getSlug()]), 'changefreq' => 'weekly', 'priority' => '1.0'];
        }


        // Once our array is filled, we define the controller response
        $response = new Response();
        $response->headers->set('Content-Type', 'xml');

        return $this->render('/seo/sitemaps.xml.twig', [
            'urls' => $urls,
            'hostname' => $hostname
        ]);
    }


}
