<?php

namespace App\Controller;

use App\Entity\TypeLieux;
use App\Form\TypeLieuxType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/type/lieux")
 */
class TypeLieuxController extends AbstractController
{
    /**
     * @Route("/", name="app_type_lieux_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $typeLieuxes = $entityManager
            ->getRepository(TypeLieux::class)
            ->findAll();

        return $this->render('type_lieux/index.html.twig', [
            'type_lieuxes' => $typeLieuxes,
        ]);
    }

    /**
     * @Route("/new", name="app_type_lieux_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeLieux = new TypeLieux();
        $form = $this->createForm(TypeLieuxType::class, $typeLieux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeLieux);
            $entityManager->flush();

            return $this->redirectToRoute('app_type_lieux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_lieux/new.html.twig', [
            'type_lieux' => $typeLieux,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{idTypeLieu}", name="app_type_lieux_show", methods={"GET"})
     */
    public function show(TypeLieux $typeLieux): Response
    {
        return $this->render('type_lieux/show.html.twig', [
            'type_lieux' => $typeLieux,
        ]);
    }

    /**
     * @Route("/{idTypeLieu}/edit", name="app_type_lieux_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TypeLieux $typeLieux, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeLieuxType::class, $typeLieux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_type_lieux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_lieux/edit.html.twig', [
            'type_lieux' => $typeLieux,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{idTypeLieu}", name="app_type_lieux_delete", methods={"POST"})
     */
    public function delete(Request $request, TypeLieux $typeLieux, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeLieux->getIdTypeLieu(), $request->request->get('_token'))) {
            $entityManager->remove($typeLieux);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_type_lieux_index', [], Response::HTTP_SEE_OTHER);
    }
}
