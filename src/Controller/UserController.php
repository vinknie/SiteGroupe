<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserController extends AbstractController
{


    /**
     * @Route("admin/user", name="user_list")
     */
    public function list(){
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $user,
        ]);

    } 

    /**
     * @Route("admin/user/add", name="user_add")
     */
    public function new(Request $request,EntityManagerInterface $manager,UserPasswordEncoderInterface $encoder)
    {
        
        $user = new User();
        $form = $this->createForm(UserType::class, $user);      
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
         {
            $hash = $encoder->encodePassword($user,$user->getPassword()); 
             $user->setPassword($hash);

             switch($user->getFunction()){
                 case 'admin': $user->setRoles(['ROLE_ADMIN']); break;
                 case 'student': $user->setRoles(['ROLE_STUDENT']); break;
                 case 'teacher': $user->setRoles(['ROLE_TEACHER']); break;
             }
        

         $manager->persist($user); 
         $manager->flush(); 

            $this->addFlash('success', "L'utilisateur a bien été ajouté !");
            return $this->redirectToRoute('user_list');
            
        } 
        return $this->render('user/form.html.twig', [
            'form' => $form->createView(),
            'editMode' => $user->getId() !== null
        ]);   
       
    }


    /**
     * @Route("admin/user/edit/{id}", name="user_edit")
     */
    public function update($id, Request $request)
    {
        
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        $form = $this->createForm(UserType::class, $user);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            switch($user->getFunction()){
                case 'admin': $user->setRoles(['ROLE_ADMIN']); break;
                case 'student': $user->setRoles(['ROLE_STUDENT']); break;
                case 'teacher': $user->setRoles(['ROLE_TEACHER']); break;
            }
            
           $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('primary', "L'utilisateur a bien été modifié !");
    
            return $this->redirectToRoute('user_list');
        } 

       return $this->render('user/form.html.twig', [
        'form' => $form->createView(),
        'editMode' => $user->getId() !== null
    ]);
    
    }


        /**
     * @Route("admin/user/remove/{id}", name="user_remove")
     */
    public function remove($id, Request $request)
    {

      
        
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);
        $entityManager->remove($user);
    

            $entityManager->flush();

            $this->addFlash('danger', "L'utilisateur a bien été supprimé !");

            return $this->redirectToRoute('user_list');
           

    
    }


     /**
     * @Route("/connexion", name="user_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
     
        // Si l'utilisateur est déjà connecté on le redirige vers la page blog
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
        {
      
            return $this->redirectToRoute('admin');
        }elseif ($this->get('security.authorization_checker')->isGranted('ROLE_USER'))
        {
           
            return $this->redirectToRoute('home');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();


      


        return $this->render('user/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]); 
    }

    /**
     * @Route("/deconnexion", name="user_logout")
     */
    public function logout(){
        // cette fonction ne retourne rien, il nous suffit d'avoir une route pour la deconnexion, une fois créer, modifier le providers form_login
    }

   
}
