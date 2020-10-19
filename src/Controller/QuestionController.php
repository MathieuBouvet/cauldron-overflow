<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController
{
    /**
     * @Route("/")
     */
    public function homepage()
    {
        return new Response('Hello World ;)');
    }

    /**
     * @Route("/question/{slug}")
     */
    public function quesion($slug)
    {
        return new Response('the answer to ' . $slug . ' is 42');
    }
}
