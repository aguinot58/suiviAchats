<?php

namespace App\Controller;

use App\Entity\Achats;
use App\Form\AchatsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/achats")
 */
class AchatsController extends AbstractController
{
    /**
     * @Route("/", name="app_achats_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $achats = $entityManager
            ->getRepository(Achats::class)
            ->findAll();

        return $this->render('achats/index.html.twig', [
            'achats' => $achats,
        ]);
    }

    /**
     * @Route("/new", name="app_achats_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $achat = new Achats();
        $form = $this->createForm(AchatsType::class, $achat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
    public function edit(Request $request, Achats $achat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AchatsType::class, $achat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
