<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchTypeBar extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('mots', SearchType::class, [
            'label' => false,
            'attr' => [
                'class' => 'form-control me-sm-2',
                'placeholder' => 'Entrez un mot-clé'
            ]
        ])
        ->add('Rechercher', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-secondary my-2 my-sm-0'
            ]
        ])
        ->setMethod('GET')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'attr' => [
                'class' => 'd-flex'
            ]
        ]);
    }
}
