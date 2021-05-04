<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Form\QuizType;
use App\Form\ShareType;
use App\Entity\Quizreply;
use App\Form\QuizreplyType;
use App\Repository\QuizRepository;
use Symfony\Component\Mime\Address;
use App\Repository\QuestionRepository;
use App\Repository\QuizreplyRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/quiz")
 */
class QuizController extends AbstractController
{
    /**
     * @Route("/index", name="quiz_index")
     */
    public function index(QuizRepository $quizRepository): Response
    {
        return $this->render('quiz/index.html.twig', [
            'quizzes' => $quizRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="quiz_new")
     */
    public function new(Request $request): Response
    {
        $quiz = new Quiz();
        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quiz);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('quiz/new.html.twig', [
            'quiz' => $quiz,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/quiz/{id}", name="quiz_show", methods={"GET"})
     */

    public function show(Quiz $quiz): Response
    {
        return $this->render('quiz/show.html.twig', [
            'quiz' => $quiz,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="quiz_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Quiz $quiz): Response
    {
        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('quiz_index');
        }

        return $this->render('quiz/edit.html.twig', [
            'quiz' => $quiz,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="quiz_delete", methods={"POST"})
     */
    public function delete(Request $request, Quiz $quiz): Response
    {
        if ($this->isCsrfTokenValid('delete' . $quiz->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($quiz);
            $entityManager->flush();
        }

        return $this->redirectToRoute('quiz_index');
    }


    /**
     * @Route("/share", name="quiz_share")
     */
    public function share(QuizreplyRepository $quizreplyRepository, MailerInterface $mailer, Request $request): Response
    {
        $form = $this->createForm(ShareType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $quiz = $form->get('quiz')->getData();
            $quizEmail = explode("\n", $form->get('email')->getData());
            for ($i = 0; $i < count($quizEmail); $i++) {
                $quizReply = new Quizreply();
                $verif = "quiz-" . $quiz->getId() . "-" . hash('ripemd160', $quizEmail[$i]);
                if (!empty($quizreplyRepository->findOneByVerifcode($verif)) and !empty($quizreplyRepository->findOneByQuiz($quiz->getId()))) {
                    $this->addFlash('success', "Impossible de partager ce quiz car certaines personnes on déjà reçu le  lien pour y répondre");
                    return $this->redirectToRoute('home');
                }
                $quizReply->setQuiz($quiz)
                    ->setEmail($quizEmail[$i])
                    ->setValide(true)
                    ->setVerifcode($verif);
                $email = (new TemplatedEmail())
                    ->from(new Address('hacenesahraoui.paris@gmail.com', 'Handy-quiz'))
                    ->Bcc($quizEmail[$i])
                    ->subject("Répondre au quiz proposer par Handy-Quiz")
                    ->htmlTemplate('quiz/shareEmail.html.twig')
                    ->context([
                        "quizid" => $quiz->getId(),
                        "quizemailhash" => $verif
                    ]);
                $mailer->send($email);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($quizReply);
            }
            $entityManager->flush();

            $this->addFlash('success', "Le quiz vient d'être partager.");
            return $this->redirectToRoute('home');
        }

        return $this->render('quiz/share.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
