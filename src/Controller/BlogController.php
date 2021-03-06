<?php
// src/Controller/BlogController.php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleSearchType;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends AbstractController
{		
	/**
  * @Route("/blog", name="blog_index")
  */
  public function index():Response
  { 
    $form = $this->createForm(
          ArticleSearchType::class, null,['method' => Request::METHOD_GET]);

		$articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

    if (!$articles) {
      throw $this->createNotFoundException('No article found in article\'s table.');
    }

    return $this->render(
       'blog/index.html.twig', [
           'articles' => $articles,
           'form' => $form->createView()
        ]);
    }

/**
 * Getting an article with a formatted slug for title
 *
 * @param string $slug The slugger
 *
 * @Route("/blog/{slug<^[ a-z0-9-]+$>}",
 *     defaults={"slug" = null},
 *     name="blog_show")
 *  @return Response A response instance
 */
 public function show(?string $slug) : Response
 {
     if (!$slug) {
            throw $this
            ->createNotFoundException('No slug has been sent to find an article in article\'s table.');
        }

     $slug = preg_replace(
      '/-/',
      ' ', ucwords(trim(strip_tags($slug)), "-")
        );

     $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);

     if (!$article) {
          throw $this->createNotFoundException(
          'No article with '.$slug.' title, found in article\'s table.'
      );
    }

     return $this->render(
     'blog/show.html.twig',
      [
              'article' => $article,
              'slug' => $slug,
      ]
    );
  }

  /**
   * Getting a list of all articles from a category name
   *
   * @param string $slug The slugger
   *
   * @Route("/blog/category/{name}",
   *     name="show_category")
   *  @return Response A response instance
   */
  public function showByCategory(Category $category) : Response
   {

    $articles = $category->getArticles();
    return $this->render(
     'blog/category.html.twig',
      [
              'articles' => $articles,
              'category' => $category
      ]
    );       
  }
}