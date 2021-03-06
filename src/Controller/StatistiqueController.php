<?php

namespace App\Controller;

use App\Repository\QuizRepository;
use App\Repository\ReponseRepository;
use App\Repository\QuestionRepository;
use App\Repository\QuizreplyRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    /**
     * @Route("/statistique")
     */
class StatistiqueController extends AbstractController
{
    /**
     * @Route("/general", name="quiz_general")
     * @Route("/quiz", name="quiz_stat")
     * @Route("/accueil", name="quiz_stathome")
     **/
    public function statistique(ReponseRepository $reponserepository, QuestionRepository $questionrepository, QuizRepository $quizrepository, QuizreplyRepository $quizreplyRepository, Request $request): Response
    {
                    $qrr = $quizreplyRepository;
            $rr = $reponserepository;
            if ($request->attributes->get('_route') == "quiz_general") {
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
                "nbquestion" => count($q->findAll()),
"nbreponse_question" => count($rr->findAll())/count($q->findAll())
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
