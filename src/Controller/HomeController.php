<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ContactTypes;
use App\Repository\UserRepository;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/accueil", name="home")
     */
    public function index(UserRepository $userrepository, Request $request): Response
    {
        if (empty($userrepository->findAll())) {
            $this->addFlash('warning', 'Il est préférable d\'initialiser la première venue sur le site');
            return $this->redirectToRoute('app_register');
        }
        if ($this->getUser() != null and $this->getUser()->isVerified() == false) {
            return $this->redirectToRoute('app_logout');
            
        }
        return $this->render('home/index.html.twig', []);
    }

    /**
     * @Route("/contact", name="home_contact")
     */
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactTypes::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new TemplatedEmail())
                ->from(new Address('hacenesahraoui.paris@gmail.com', 'Sahreply'))
                ->to("hacenesahraoui.paris@gmail.com")
                ->subject($form->get('request')->getData())
                ->htmlTemplate('contact/contact.html.twig')
                ->context([
                    "request" => $form->get('request')->getData(),
                    "addemail" => $form->get('email')->getData(),
                    "phone" => $form->get('phone')->getData(),
                    "content" => $form->get('content')->getData()
                ]);
            $mailer->send($email);
            $this->addFlash('success', 'Votre message a été transmis, nous vous répondrons dans les meilleurs délais.');
            return $this->redirectToRoute('home_contact');
        }
        return $this->render('contact/index.html.twig', ['contactForm' => $form->createView()]);
    }
}
