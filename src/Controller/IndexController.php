<?php

namespace App\Controller;


use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {
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

        return $this->render('index.html.twig', [
            'formContact' => $form->createView(),
            'projects' => [],
        ]);
    }

    /**
     * @Route("/jobs", name="jobs")
     */
    public function showJobs()
    {
        return $this->render('/jobs/jobs.html.twig', [
        ]);
    }


    /**
     * @Route("/about", name="about")
     */
    public function showAbout()
    {
        return $this->render('/about/about.html.twig', [
        ]);
    }

}
