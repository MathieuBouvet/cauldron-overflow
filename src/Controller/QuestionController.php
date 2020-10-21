<?php

namespace App\Controller;

use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;

class QuestionController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage()
    {
        return $this->render('question/homepage.html.twig');
    }

    /**
     * @Route("/question/{slug}", name="app_question_show")
     */
    public function show(
        $slug,
        MarkdownParserInterface $parser,
        CacheInterface $cache
    ) {
        $questionText =
            "I've been turned into a cat, any *thoughts* on how to turn back?" .
            " While I'm **adorable**, I don't really care for cat food.";
        $cache->get('markdown_' . md5($questionText), function () use (
            $parser,
            $questionText
        ) {
            return $parser->transformMarkdown($questionText);
        });
        $parsedQuestionText = $parser->transformMarkdown($questionText);
        $answers = [
            'Make sure your cat is sitting `purrrfectly` still 🤣',
            'Honestly, I like furry shoes better than MY cat',
            'Maybe... try saying the spell backwards?',
        ];
        return $this->render('question/show.html.twig', [
            'question' => ucwords(str_replace('-', ' ', $slug)),
            'answers' => $answers,
            'questionText' => $parsedQuestionText,
        ]);
    }
}
