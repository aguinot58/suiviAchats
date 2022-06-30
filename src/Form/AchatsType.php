<?php

namespace App\Form;

use App\Entity\Achats;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class AchatsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idProd')
            ->add('idUser')
            ->add('dateAchat', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('dateGarAchat', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('prixAchat')
            //->add('photoTicketAchat')
            ->add('ticket', FileType::class, [
                'label' => 'Ticket de caisse (JPG)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '10240k',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/x-jpg',
                            'image/jpeg',
                            'image/x-jpeg',
                        ],
                        'mimeTypesMessage' => 'Merci de Sélectionner une document JPG valide',
                    ])
                ],
            ])
            ->add('idTypeLieu')
            ->add('lieuAchat')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Achats::class,
        ]);
    }
}
