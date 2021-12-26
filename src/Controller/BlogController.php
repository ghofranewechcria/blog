<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Entity\Comment;
use App\Form\CommentType;

class BlogController extends AbstractController
{
   /**
     * @Route("/blog", name="blog")
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);

        $articles = $repo->findAll();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles 
        ]);
    }
    /** 
    * @Route("/", name="home")
    */
    public function home() {
        return $this->render('blog/home.html.twig');
    }
    



/**
     * @Route("/blog/new" , name="blog_create")
     * @Route("/blog/{id}/edit" , name="blog_edit")
     */
    public function form( Article $article  = null, Request $request, EntityManagerInterface $manager)
    {
        if(!$article) {
         $article = new Article();
        }
     
     

      $form= $this->createForm(ArticleType::class ,$article);

      $form->handleRequest($request);
      

      if($form->isSubmitted() && $form->isValid())
      {
          if(!$article->getId()){
              $article->setCreatedAt(new \DateTime());
          }
          
          $manager->persist($article);
          $manager->flush();
          return $this->redirectToRoute('blog_show' , [ 'id' => $article->getId()]);
      }
      
  
      return $this->render('blog/create.html.twig' , [
          'formArticle' => $form->createView() ,
          'editMode' => $article->getId() !== null
      ]);
    }


    public function adminDashboard(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
    
        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
    }


    /**
     * @Route("/blog/{id}" , name="blog_show")
     */
    public function show(Article $article , Request $request , EntityManagerInterface $manager ) {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class , $comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
          $comment->setCreatedAt(new \DateTime() )
                  ->setArticle($article);
          $manager->persist($comment);
          $manager->flush();
          return $this->redirectToRoute('blog_show' , [
              'id'=> $article->getId()
          ]);
        }
        return $this->render('blog/show.html.twig' , [
            'article' => $article,
            'commentForm' => $form->createView()
        ]);
     }

}
