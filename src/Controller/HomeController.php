<?php

namespace App\Controller;

use App\Form\ContactTypes;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function index(): Response
    {
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
