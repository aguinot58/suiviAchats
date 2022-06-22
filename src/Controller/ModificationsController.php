<?php

namespace App\Controller;

use App\Entity\Modifications;
use App\Form\ModificationsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/modifications")
 */
class ModificationsController extends AbstractController
{
    /**
     * @Route("/", name="app_modifications_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $modifications = $entityManager
            ->getRepository(Modifications::class)
            ->findAll();

        return $this->render('modifications/index.html.twig', [
            'modifications' => $modifications,
        ]);
    }

    /**
     * @Route("/new", name="app_modifications_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $modification = new Modifications();
        $form = $this->createForm(ModificationsType::class, $modification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($modification);
            $entityManager->flush();

            return $this->redirectToRoute('app_modifications_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('modifications/new.html.twig', [
            'modification' => $modification,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{idModif}", name="app_modifications_show", methods={"GET"})
     */
    public function show(Modifications $modification): Response
    {
        return $this->render('modifications/show.html.twig', [
            'modification' => $modification,
        ]);
    }

    /**
     * @Route("/{idModif}/edit", name="app_modifications_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Modifications $modification, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ModificationsType::class, $modification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_modifications_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('modifications/edit.html.twig', [
            'modification' => $modification,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{idModif}", name="app_modifications_delete", methods={"POST"})
     */
    public function delete(Request $request, Modifications $modification, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$modification->getIdModif(), $request->request->get('_token'))) {
            $entityManager->remove($modification);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_modifications_index', [], Response::HTTP_SEE_OTHER);
    }
}
