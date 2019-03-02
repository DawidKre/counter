<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app",name="app")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/{vueRouting}", requirements={"vueRouting"="^(?!counter|api|login|logout|_(profiler|wdt)).*"}, name="vue")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
