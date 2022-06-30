<?php

namespace App\Controller;

use App\Entity\Achats;
use App\Form\AchatsType;
use App\Form\SearchTypeBar;
use App\Service\FileUploaderTicket;
use App\Repository\AchatsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/achats")
 */
class AchatsController extends AbstractController
{
    /**
     * @Route("/", name="app_achats_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager, Request $request, AchatsRepository $achatsRepo): Response
    {
        $achats = $entityManager
            ->getRepository(Achats::class)
            ->findAll();

        $form = $this->createForm(SearchTypeBar::class);

        $search = $form->handleRequest($request);

        /*if($form->isSubmitted() && $form->isValid()) {

            $achats = $achatsRepo->search($search->get('mots')->getData());
        
        }*/
        

        return $this->render('achats/index.html.twig', [
            'achats' => $achats,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="app_achats_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, FileUploaderTicket $fileUploader): Response
    {
        $achat = new Achats();
        $form = $this->createForm(AchatsType::class, $achat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $ticketFile = $form->get('ticket')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($ticketFile) {
                $ticketFileName = $fileUploader->upload($ticketFile);
                $achat->setPhotoTicketAchat($ticketFileName);
            }

            $entityManager->persist($achat);
            $entityManager->flush();

            return $this->redirectToRoute('app_achats_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('achats/new.html.twig', [
            'achat' => $achat,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{idAchat}", name="app_achats_show", methods={"GET"})
     */
    public function show(Achats $achat): Response
    {
        return $this->render('achats/show.html.twig', [
            'achat' => $achat,
        ]);
    }

    /**
     * @Route("/{idAchat}/edit", name="app_achats_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Achats $achat, EntityManagerInterface $entityManager, FileUploaderTicket $fileUploader): Response
    {
        $form = $this->createForm(AchatsType::class, $achat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $ticketFile = $form->get('ticket')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($ticketFile) {
                $ticketFileName = $fileUploader->upload($ticketFile);
                $achat->setPhotoTicketAchat($ticketFileName);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_achats_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('achats/edit.html.twig', [
            'achat' => $achat,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{idAchat}", name="app_achats_delete", methods={"POST"})
     */
    public function delete(Request $request, Achats $achat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$achat->getIdAchat(), $request->request->get('_token'))) {
            $entityManager->remove($achat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_achats_index', [], Response::HTTP_SEE_OTHER);
    }
}
