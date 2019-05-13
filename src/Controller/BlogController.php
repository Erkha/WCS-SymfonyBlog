<?php
// src/Controller/BlogController.php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;


class BlogController extends AbstractController
{		
		/**
    * @Route("/blog", name="blog_index")
    */
    public function index():Response
    {
			$articles = $this->getDoctrine()
          ->getRepository(Article::class)
          ->findAll();

      if (!$articles) {
          throw $this->createNotFoundException(
          'No article found in article\'s table.'
          );
      }

      return $this->render(
              'blog/index.html.twig',
              ['articles' => $articles]
      );
    }

  /**
   * @Route("/blog/show/{slug}", requirements={"slug"="[a-z\-0-9]+"}, name="blog_show")
   */
    public function show($slug ='Article Sans Titre')
    {
    	$slug = ucwords(str_replace('-', ' ', $slug));
	    return $this->render('blog/show.html.twig', [
	            'slug' => $slug
	    ]);
    }
}