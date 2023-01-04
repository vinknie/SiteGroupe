<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Form\SubjectType;
use App\Repository\SubjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BackofficeController extends AbstractController
{

    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        if(!$this->isGranted("ROLE_ADMIN"))
        {
            return $this->redirectToRoute('blog');
        }

        return $this->render('backoffice/index.html.twig', [
            'controller_name' => 'BackofficeController',
        ]);
    }
    /**
     * @Route("/admin/backSubject", name="backSubject")
     */
    public function backSubject(SubjectRepository $repo)
    {
        $repo= $this->getDoctrine()->getRepository(Subject::class);
        $subject= $repo->findAll();


        return $this->render('backoffice/subject/backSubject.html.twig', [
            'controller_name' => 'BackofficeController',
            'subject' => $subject,
        ]);

    }

    /**
     * @Route("/admin/addSubject", name="addSubject")
     */
    public function addSubject(Request $request, EntityManagerInterface $manager )
    {    
        $subject = new Subject;
        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($subject);
            $manager->flush();
            $this->addFlash('success','Ajout réussi !');
            return $this->redirectToRoute('backSubject');
        }

        return $this->render('backoffice/subject/addSubject.html.twig',[
            'controller_name'=> 'BacofficeController',
            'subject'=> $subject,
            'form'=> $form->createView()
        ]);

    }
    /**
     * @Route("/admin/editSubject/{id}", name="editSubject" , methods={"GET","POST"})
     */
    public function editSubject(Subject $subject, Request $request, EntityManagerInterface $manager)
        {
            $form = $this->createForm(SubjectType::class, $subject);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid())
            {
                $manager->flush();
                $this->addFlash('success','Modification réussi !');
                return $this->redirectToRoute('backSubject');
            }

            return $this->render('backoffice/subject/editSubject.html.twig',[
                'controller_name'=> 'BackofficeController',
                'subject'=> $subject,
                'form'=> $form->createView()
            ]);
        }
    /**
     * @Route("/admin/editSubject/{id}", name="deleteSubject" , methods={"DELETE"})
     */
    public function deleteSubject(Subject $subject, EntityManagerInterface $manager, Request $request )
    {    
       if($this->isCsrfTokenValid('delete'. $subject->getId(),$request->get('_token')))
       {
            $manager->remove($subject);
            $manager->flush();
            $this->addFlash('success','Suppression réussie !');

            return $this->redirectToRoute('backSubject');
       }



    }




}
