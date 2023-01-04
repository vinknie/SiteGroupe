<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\MenuRepository;
use App\Repository\NewsRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index()
    {

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',

        ]);
    }
    /**
     * @Route("/", name="home")
     */
    public function home(NewsRepository $repository)
    {
        $article1 = $repository->find(1);
        dump($article1);
        $article2 = $repository->find(2);
        dump($article2);
        $article3 = $repository->find(3);
        dump($article3);



        return $this->render('blog/home.html.twig', [
            'title' => 'Bienvenue sur la page d\'acceuil',
            'article1' => $article1,
            'article2' => $article2,
            'article3' => $article3,

        ]);
    }
    /**
     * @Route("/presentation", name="presentation")
     */
    public function presentation()
    {

        return $this->render('blog/presentation.html.twig', [
            'title' => 'Bienvenue sur le page de presentation'
        ]);
    }

    /**
     * @Route("/reglement", name="reglement")
     */
    public function reglement()
    {

        return $this->render('blog/reglement.html.twig', [
            'title' => 'Bienvenue sur le page de reglement'
        ]);
    }


    /**
     * @Route("/ecole", name="ecole")
     */
    public function ecole()
    {

        return $this->render('blog/ecole.html.twig', [
            'title' => 'Bienvenue sur le page de l\'ecole'
        ]);
    }

    /**
     * @Route("/cantine", name="cantine")
     */
    public function cantine(MenuRepository $repository)
    {
        $lundi = $repository->find(1);
        dump($lundi);
        $mardi = $repository->find(2);
        dump($mardi);
        $mercredi = $repository->find(3);
        dump($mercredi);
        $jeudi = $repository->find(4);
        dump($jeudi);
        $vendredi = $repository->find(5);
        dump($vendredi);

        return $this->render('blog/cantine.html.twig', [
            'title' => 'Bienvenue sur le page de la cantine',
            'lundi' => $lundi,
            'mardi' => $mardi,
            'mercredi' => $mercredi,
            'jeudi' => $jeudi,
            'vendredi' => $vendredi,
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {

        $retour = mail('lovezoupi@gmail', 'Envoi depuis la page Contact', $_POST['message'], 'From: ' . $_POST['email']);
        // if ($retour) {
        //     echo '<p>Votre message a bien été envoyé.</p>';
        // }

        return $this->render('blog/ecole.html.twig', [
            'title' => 'Bienvenue sur le page de contact',
            'retour' => $retour,

        ]);
    }
}
