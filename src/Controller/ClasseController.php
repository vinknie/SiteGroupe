<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Form\ClasseType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClasseController extends AbstractController
{
    /**
     * @Route("admin/classe", name="classe_list")
     */
    public function list(){
        $classe = $this->getDoctrine()
        ->getRepository(Classe::class)
        ->findAll();

        return $this->render('classe/index.html.twig', [
            'classes' => $classe,
        ]);

    } 

    /**
     * @Route("admin/classe/add", name="classe_add")
     */
    public function new(Request $request)
    {
        
        $classe = new Classe();

        $form = $this->createForm(ClasseType::class, $classe);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $classe = $form->getData();
    
           
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($classe);
            $entityManager->flush();
    
            $this->addFlash('success', "La classe a bien été ajoutée !");

            return $this->redirectToRoute('classe_list');
            
            
        }

        return $this->render('classe/form.html.twig', [
            'form' => $form->createView(),
            'editMode' => $classe->getId() !== null
        ]);
      
       
    }


    /**
     * @Route("admin/classe/edit/{id}", name="classe_edit")
     */
    public function update($id, Request $request)
    {
        
        $entityManager = $this->getDoctrine()->getManager();
        $classe = $entityManager->getRepository(Classe::class)->find($id);

        $form = $this->createForm(ClasseType::class, $classe);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
           $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('primary', "La classe a bien été modifiée !");
    
            return $this->redirectToRoute('classe_list');
        } 

       return $this->render('classe/form.html.twig', [
        'form' => $form->createView(),
        'editMode' => $classe->getId() !== null
    ]);
    
    }


        /**
     * @Route("admin/classe/remove/{id}", name="classe_remove")
     */
    public function remove($id, Request $request)
    {

      
        
        $entityManager = $this->getDoctrine()->getManager();
        $classe = $entityManager->getRepository(Classe::class)->find($id);
        $entityManager->remove($classe);
    

        $entityManager->flush();

        $this->addFlash('danger', "La classe a bien été supprimée !");

        return $this->redirectToRoute('classe_list');
           

    
    }

   
}
