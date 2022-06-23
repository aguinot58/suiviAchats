<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeLieux
 *
 * @ORM\Table(name="type_lieux")
 * @ORM\Entity
 */
class TypeLieux
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_type_lieu", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTypeLieu;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_type_lieu", type="string", length=50, nullable=false)
     */
    private $nomTypeLieu;

    public function getIdTypeLieu(): ?int
    {
        return $this->idTypeLieu;
    }

    public function getNomTypeLieu(): ?string
    {
        return $this->nomTypeLieu;
    }

    public function setNomTypeLieu(string $nomTypeLieu): self
    {
        $this->nomTypeLieu = $nomTypeLieu;

        return $this;
    }

    public function __toString()
    {
        return $this->nomTypeLieu;
    }


}
