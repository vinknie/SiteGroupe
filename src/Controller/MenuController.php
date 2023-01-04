<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Form\MenuType;
use App\Repository\MenuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MenuController extends AbstractController
{
    /**
     * @Route("/admin/menu", name="indexMenu")
     */
    public function index(MenuRepository $repo)
    {
        $repo= $this->getDoctrine()->getRepository(Menu::class);
        $menu= $repo->findAll();
        dump($menu);
        return $this->render('menu/index.html.twig', [
            'controller_name' => 'MenuController',
            'menu'=> $menu,
        ]);
    }
    /**
     * @Route("/admin/editMenu/{id}", name="editMenu")
     */
    public function editMenu(Menu $menu,Request $request,EntityManagerInterface $manager)
    {
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);
        $day= array('lundi','mardi','mercredi','jeudi','vendredi');
        dump($day);


        if ($form->isSubmitted() && $form->isValid())
        {

          
            $manager->flush();
            $this->addFlash('success','Modification réussi !');
            return $this->redirectToRoute('indexMenu');
        }

        return $this->render('menu/editMenu.html.twig', [
            'controller_name' => 'NewsController',
            'menu'=> $menu,
            'days'=> $day,
            'form'=> $form->createView()
            
        ]);
    }
}
