<?php

namespace App\Controller;

use App\Entity\News;
use App\Form\NewsType;
use App\Repository\NewsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NewsController extends AbstractController
{
    /**
     * @Route("/admin/indexNews", name="indexNews")
     */
    public function index(NewsRepository $repo)
    {
        
        $repo= $this->getDoctrine()->getRepository(News::class);
        $news= $repo->findAll();
        return $this->render('news/index.html.twig', [
            'controller_name' => 'NewsController',
            'news'=> $news,
        ]);
        dump($news);
        
    }
    /**
     * @Route("/admin/editNews/{id}", name="editNews", methods={"GET","POST"})
     */
    public function editNews(News $news, Request $request, EntityManagerInterface $manager)
    { 
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $news->setDate(new \DateTime());
            $manager->flush();
            $this->addFlash('success','Modification réussi !');
            return $this->redirectToRoute('indexNews');
        }

        return $this->render('news/editNews.html.twig', [
            'controller_name' => 'NewsController',
            'news'=> $news,
            'form'=> $form->createView()
            
        ]);
    }



    
}
