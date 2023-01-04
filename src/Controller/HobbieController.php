<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HobbieController extends AbstractController
{
    /**
     * @Route("/hobbie", name="hobbie")
     */
    public function index()
    {
        return $this->render('hobbie/index.html.twig', [
            'controller_name' => 'HobbieController',
        ]);
    }
     /**
     * @Route("/club", name="club")
     */
    public function club()
    {
        return $this->render('hobbie/club.html.twig', [
            'controller_name' => 'Bienvenue sur la page des clubs sportifs',
        ]);
    }
     /**
     * @Route("/voyage", name="voyage")
     */
    public function voyage()
    {
        return $this->render('hobbie/voyage.html.twig', [
            'controller_name' => 'Bienvenue sur la page des voyages',
        ]);
    }
     /**
     * @Route("/media", name="media")
     */
    public function media()
    {
        return $this->render('hobbie/media.html.twig', [
            'controller_name' => 'Bienvenue sur la mediatheque',
        ]);
    }
}
