<?php

namespace App\Controller;

use App\Entity\Quizreply;
use App\Repository\QuizRepository;
use App\Repository\ReponseRepository;
use App\Repository\QuizreplyRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/repondre")
 */
class ReplyController extends AbstractController
{
    /**
     * @Route("/{id}/{verif}", name="reply_repondre", methods={"GET", "POST"})
     */
    public function reply(ReponseRepository $reponserepository, QuizRepository $quizRepository, QuizreplyRepository $quizreplyRepository, Request $request): Response
    {
        $urlemail = $request->attributes->get('_route_params')['verif'];
        $urlquiz = $request->attributes->get('_route_params')['id'];
        $quizobjet = $quizRepository->findById($urlquiz);
        if (empty($quizreplyRepository->findOneByVerifcode($urlemail)) or $quizreplyRepository->findOneByVerifcode($urlemail)->getQuiz()->getId() != $urlquiz or $quizreplyRepository->findOneByVerifcode($urlemail)->getValide() == false) {
            $this->addFlash('warning', "Impossible de répondre à ce quiz car vous n'êtes pas habilité à le faire.");
            return $this->redirectToRoute('home');
        } else if (!empty($_POST)) {
            $idquizreply = $quizreplyRepository->findOneByVerifcode($urlemail)->getId();
            $em = $this->getDoctrine()->getManager();
            $quizreply = $em->getRepository(Quizreply::class)->find($idquizreply);
            if (!$quizreply) {
                throw $this->createNotFoundException('Aucun quizreply trouvé pour l\'identifiant' . $urlquiz);
            }
            $quizreply->setValide(0);
            $quizreply->setCreatedAt(new \DateTime());
            foreach ($_POST as $cle => $valeur) {
                $quizreply->addChoix($reponserepository->findOneById($valeur));
            }
            $em->flush();
            $this->addFlash('warning', "Vous venez de répondre à ce quiz, merci!");
            return $this->redirectToRoute('home');
        }
        return $this->render('reply/reply.html.twig', [
            "quizquestion" => $quizobjet
        ]);
    }


    /**
     * @Route("/reply-index", name="reply_index")
     */
    public function replyindex(QuizreplyRepository $quizreplyrepository): Response
    {
        return $this->render('reply/replyindex.html.twig', [
            'reponse' => $quizreplyrepository->findAll(),
        ]);
    }

    /**
     * @Route("/display-{id}", name="reply_show", methods={"GET"})
     */
    public function replydisplay(Quizreply $quizreply, quizreplyRepository $quizreplyrepository): Response
    {
        if ($quizreply->getCreatedAt() != null) {
            return $this->render('reply/displayreply.html.twig', [
                'displays' => $quizreplyrepository->findOneById($quizreply->getId()),
            ]);
        }
    }
}
