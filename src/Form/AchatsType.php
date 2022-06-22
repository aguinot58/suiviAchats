<?php

namespace App\Form;

use App\Entity\Achats;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AchatsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateAchat')
            ->add('dateGarAchat')
            ->add('prixAchat')
            ->add('photoTicketAchat')
            ->add('lieuAchat')
            ->add('idProd')
            ->add('idUser')
            ->add('idTypeLieu')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Achats::class,
        ]);
    }
}
