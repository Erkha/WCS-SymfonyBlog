<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Article;


class DefaultController extends AbstractController
{		
		/**
    * @Route("/", name="app_index")
    */
    public function index()
    {
	    return $this->render('default.html.twig');
    }
}