<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    /**
     * The function display the homepage
     *
     * @Route("/", name="homepage")
     *
     * @return Response
     */
    public function indexAction() : Response
    {
        return $this->render('default/index.html.twig');
    }
}
