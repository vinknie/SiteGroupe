<?php

namespace App\Controller;


use App\Form\PlanningType;
use App\Entity\PlanningSubject;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PlanningSubjectRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PlanningController extends AbstractController
{
    /**
     * @Route("/admin/indexPlanning", name="indexPlanning")
     */
    public function index(PlanningSubjectRepository $repo)
    {
       
        $repo= $this->getDoctrine()->getRepository(PlanningSubject::class);
        $planning= $repo->findAll();
        dump($planning);

        return $this->render('planning/index.html.twig', [
            'controller_name' => 'PlanningController',
            'planning' => $planning,
        ]);
        
    }
    /**
     * @Route("/admin/editPlanning/{id}", name="editPlanning", methods={"GET","POST"})
     */
    public function editPlanning(PlanningSubject $planning, Request $request,EntityManagerInterface $manager )
    {
        $form = $this->createForm(PlanningType::class, $planning);
        $form->handleRequest($request);
        dump($form);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->flush();
            $this->addFlash('success','Modification réussi !');
            return $this->redirectToRoute('indexPlanning');
        }

        return $this->render('planning/editPlanning.html.twig',[
            'controller_name'=> 'PlanningController',
            'planning'=> $planning,
            'form'=> $form->createView()
        ]);
    }
    /**
     * @Route("/admin/addPlanning/", name="addPlanning")
     */
    public function addPlanning(Request $request,EntityManagerInterface $manager)
    {
        $planning= new PlanningSubject;
        $form = $this->createForm(PlanningType::class, $planning);
        $form->handleRequest($request);
        dump($form);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($planning);
            $manager->flush();
            $this->addFlash('success','Ajout réussi !');
            return $this->redirectToRoute('indexPlanning');
        }
        return $this->render('planning/addPlanning.html.twig',[
            'controller_name'=> 'PlanningController',
            'planning'=> $planning,
            'form'=> $form->createView()
        ]);
    }
    /**
     * @Route("/admin/editPlanning/{id}", name="deletePlanning", methods={"DELETE"})
     */
    public function deletePlanning(PlanningSubject $planning, Request $request,EntityManagerInterface $manager)
    {
        if($this->isCsrfTokenValid('delete'. $planning->getId(),$request->get('_token')))
        {
             $manager->remove($planning);
             $manager->flush();
             $this->addFlash('success','Suppression réussie !');
             return $this->redirectToRoute('indexPlanning');
        }
    }
}
