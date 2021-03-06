<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Category;
use App\Form\CategoryType;

class CategoryController extends AbstractController
{		
	/**
  * @Route("/category", name="category_crud")
  * @param  Request $request [description]
  */
  public function new(Request $request)
  {
      $category = new Category();

      $form = $this->createForm(
          CategoryType::class);

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
          $category = $form->getData();
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($category);
          $entityManager->flush();

          return $this->redirectToRoute('blog_index');
      }

      return $this->render('category/category_add.html.twig', [
          'form' => $form->createView(),
      ]);
}

}