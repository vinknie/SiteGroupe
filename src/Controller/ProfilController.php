<?php

namespace App\Controller;

use App\Entity\Exam;
use App\Entity\Lessons;
use App\Entity\User;
use App\Form\ExamType;
use App\Form\LessonsType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @ORM\Entity
 * @ORM\Table(name="profil_controller")
 */
class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $user = $this->getUser();

        if (null === $user) {

        } else {
            $user = new User();
        }
        return $this->render('profil/Mon_Espace.html.twig');
    }

    /**
     * @Route("/calendrier", name="program")
     */
    public function calendrier()
    {
        return $this->render('profil/calendrier.html.twig', [
            'formation' => $this->getDoctrine()->getRepository(Planning::class)->findAll()

        ]);
    }

    /**
     * @Route("/note", name="note")
     */
    public function Mon_Emploi()
    {


        return $this->render('profil/emploie.html.twig', [
            'exam' => $this->getDoctrine()->getRepository(Exam::class)->findAll()


        ]);
    }

    /**
     * @Route("/notation", name="notation")
     */
    public function MaPreparation(Request $request, EntityManagerInterface $manager)
    {
        $exam = new Exam();
        $form = $this->createForm(ExamType::class, $exam);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($exam);
            $manager->flush();

            return $this->redirectToRoute('note');


        }

        return $this->render('profil/notation.html.twig', [
            'exam' => $form->createView()

        ]);
    }

    /**
     * @Route("/liste_file", name="liste_file")
     */
    public function lister()
    {


        return $this->render('profil/liste.html.twig', [
            'liste' => $this->getDoctrine()->getRepository(Lessons::class)->findAll()

        ]);
    }

    /**
     * @Route("/file", name="add_file")
     */
    public function add_file(Request $request)
    {
        $lessons = new Lessons();
        $form = $this->createForm(LessonsType::class, $lessons);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $filesDir = $this->getParameter('files_dir');
            $file = $form["files"]->getData();
            $extensions = ["png", "jpg", "jpeg", "pdf", "doc", "docx"];
            $defaultExtension = "pdf";
            $extension = $file->guessExtension();
            if (!in_array(strtolower($extension), $extensions)) $extension = $defaultExtension;

            $fileName = (new \DateTime())->format('Ymd.His.u') . '.' . $extension;
            $path = $filesDir . "/lessons";
            if (!file_exists($path)) mkdir($path, 0775, true);
            $file->move($path, $fileName);

            $lessons->setFiles($fileName);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($lessons);
            $manager->flush();

            return $this->redirectToRoute("liste_file");


        }

        return $this->render('profil/addfile.html.twig', [
            'file' => $form->createView()

        ]);
    }


}
