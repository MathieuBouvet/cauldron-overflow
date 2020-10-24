<?php

namespace App\Controller;

use App\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class QuestionController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(EntityManagerInterface $entityManager)
    {
        $repository = $entityManager->getRepository(Question::class);
        $questions = $repository->findBy([], ['askedAt' => 'DESC']);
        return $this->render('question/homepage.html.twig', [
            'questions' => $questions,
        ]);
    }

    /**
     * @Route("/question/new")
     */
    public function new(EntityManagerInterface $entityManager)
    {
        $question = new Question();
        $question
            ->setName('Missing pants')
            ->setSlug('missing-pants-' . rand(0, 100))
            ->setQuestion(
                <<<EOF
            Hi! So... I'm having a *weird* day. Yesterday, I cast a spell
            to make my dishes wash themselves. But while I was casting it,
            I slipped a little and I think `I also hit my pants with the spell`.
            When I woke up this morning, I caught a quick glimpse of my pants
            opening the front door and walking out! I've been out all afternoon
            (with no pants mind you) searching for them.
            Does anyone have a spell to call your pants back?
            EOF
                ,
            )
            ->setAskedAt(
                rand(0, 1)
                    ? new \DateTime(sprintf('-%d days', rand(0, 100)))
                    : null,
            );
        $entityManager->persist($question);
        $entityManager->flush();
        return new Response(
            sprintf(
                'A new question has been saved. Its id is %d, and its slug is %s',
                $question->getId(),
                $question->getSlug(),
            ),
        );
    }

    /**
     * @Route("/question/{slug}", name="app_question_show")
     */
    public function show($slug, EntityManagerInterface $entityManager)
    {
        $repository = $entityManager->getRepository(Question::class);
        /** @var Question|null $question */
        $question = $repository->findOneBy(['slug' => $slug]);
        if (!$question) {
            throw $this->createNotFoundException(
                sprintf('No question found with slug %s', $slug),
            );
        }
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
}
