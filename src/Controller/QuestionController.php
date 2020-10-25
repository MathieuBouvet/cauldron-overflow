<?php

namespace App\Controller;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QuestionController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(QuestionRepository $repo)
    {
        $questions = $repo->findAllAskedOrderedByNewest();
        return $this->render('question/homepage.html.twig', [
            'questions' => $questions,
        ]);
    }

    /**
     * @Route("/question/new")
     */
    public function new(EntityManagerInterface $entityManager)
    {
        return new Response('Sounds like a GREAT feature for V2!');
    }

    /**
     * @Route("/question/{slug}", name="app_question_show")
     */
    public function show(Question $question)
    {
        $answers = [
            'Make sure your cat is sitting `purrrfectly` still 🤣',
            'Honestly, I like furry shoes better than MY cat',
            'Maybe... try saying the spell backwards?',
        ];
        return $this->render('question/show.html.twig', [
            'question' => $question,
            'answers' => $answers,
        ]);
    }

    /**
     * @Route("/question/{slug}/vote", name="app_question_vote", methods="post", )
     */
    public function vote(
        Question $question,
        Request $request,
        EntityManagerInterface $entityManager
    ) {
        $direction = $request->request->get('direction');
        if ($direction === 'up') {
            $question->upVote();
        } elseif ($direction === 'down') {
            $question->downVote();
        }
        $entityManager->flush();
        return $this->redirectToRoute('app_homepage');
    }
}
