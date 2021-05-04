<?php

namespace App\Controller;

use App\Repository\QuizRepository;
use App\Repository\QuestionRepository;
use App\Repository\QuizreplyRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StatistiqueController extends AbstractController
{
    /**
     * @Route("/statistique-general", name="quiz_general")
     * @Route("/statistique-quiz", name="quiz_stat")
     * @Route("/statistique-accueil", name="quiz_stathome")
     **/
    public function statistique(QuestionRepository $questionrepository, QuizRepository $quizrepository, QuizreplyRepository $quizreplyRepository, Request $request): Response
    {
        if ($request->attributes->get('_route') == "quiz_general") {
            $qrr = $quizreplyRepository;
            $stat = [
                "nbreponse" => count($qrr->findByValide(0)),
                "nbpareponse" => count($qrr->findByValide(1)),
                "nbpartage" => count($qrr->findAll()),
            ];
            return $this->render('statistique/statgenerale.html.twig', [
                'stats' => $stat,
            ]);
        } else if ($request->attributes->get('_route') == "quiz_stat") {
            $qr = $quizrepository;
            $q = $questionrepository;
            $stat = [
                "nbquiz" => count($qr->findAll()),
                "nbquestion" => count($q->findAll())
            ];
            return $this->render('statistique/statquiz.html.twig', [
                'stats' => $stat,
            ]);
        }
        return $this->render(
            'statistique/stat.html.twig'
        );
    }
}
