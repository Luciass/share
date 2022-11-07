<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class BaseController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(): Response
    {
        return $this->render('base/index.html.twig', [
            
        ]);
    }


    #[Route('/contact', name: 'contact')] // étape 1
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);

        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
                $email = (new Email())
                ->from($form->get('email')->getData())
                ->to('reply@nuage-pedagogique.fr')
                ->subject($form->get('sujet')->getData())
                ->text($form->get('message')->getData());
              
                $mailer->send($email);
                $this->addFlash('notice','Message envoyé');
                return $this->redirectToRoute('contact');
            }
        }

        return $this->render('base/contact.html.twig', [ // étape 3
             'form' => $form->createView()
        ]);
    }

    #[Route('/propos', name: 'propos')] // étape 1
    public function propos(): Response // étape 2
    {
        return $this->render('base/propos.html.twig', [ // étape 3
            
        ]);
    }

    #[Route('/mentionsLegales', name: 'mentionsLegales')] // étape 1
    public function mentionsLegales(): Response // étape 2
    {
        return $this->render('base/mentionsLegales.html.twig', [ // étape 3
            
        ]);
    }

}

