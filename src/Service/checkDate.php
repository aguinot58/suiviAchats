<?php

namespace App\Service;


use App\Entity\Achats;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class checkDate
{
   /**
    * @var string A "Y-m-d H:i:s" formatted value
    */
    protected $createdAt;

    public static function loadValidatorMetadata(ClassMetadata $metadata, Achats $dateAchat)
    {
        $metadata->addPropertyConstraint('createdAt', new Assert\DateTime());

        if ($metadata === $dateAchat) {
            mail('user@outlook.fr' , 'Fin de garantie' , 'Votre garantie pour votre article"" est arrivé à terme' );
        }
    }
}