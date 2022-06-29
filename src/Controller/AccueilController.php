<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use App\Service\FetchDatasGraph;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\{TextType,ButtonType,EmailType,HiddenType,PasswordType,TextareaType,SubmitType,NumberType,DateType,MoneyType,BirthdayType};


class AccueilController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function home(FetchDatasGraph $FetchDatasGraph, Request $request): Response
    {

        $form = $this->createFormBuilder()
            ->add('Date_de_debut', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('Date_de_fin', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('Rafraichir', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if ($form->get('Date_de_debut')->getData() != null ){
                $date_deb = $form->get('Date_de_debut')->getData()->format('Y-m-d');
            } else {
                $date_deb = null;
            }

            if ($form->get('Date_de_fin')->getData() != null ){
                $date_fin = $form->get('Date_de_fin')->getData()->format('Y-m-d');
            } else {
                $date_fin = null;
            }

            $donnees = $FetchDatasGraph->getDataGraph($date_deb, $date_fin);

        } else {

            $donnees = $FetchDatasGraph->getDataGraph();

        }

        return $this->render('accueil/home.html.twig', [
            'controller_name' => 'Accueil_Ctrl',
            'donnees' => $donnees,
            'form' => $form->createView(),
        ]);
    }


}