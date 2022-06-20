<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produits
 *
 * @ORM\Table(name="produits", indexes={@ORM\Index(name="id_cat", columns={"id_cat"})})
 * @ORM\Entity
 */
class Produits
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_prod", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProd;

    /**
     * @var int
     *
     * @ORM\Column(name="id_cat", type="integer", nullable=false)
     */
    private $idCat;

    /**
     * @var string
     *
     * @ORM\Column(name="manuel_prod", type="string", length=255, nullable=false)
     */
    private $manuelProd;

    /**
     * @var string
     *
     * @ORM\Column(name="infos_prod", type="string", length=1000, nullable=false)
     */
    private $infosProd;

    /**
     * @var bool
     *
     * @ORM\Column(name="efface_prod", type="boolean", nullable=false)
     */
    private $effaceProd;

    public function getIdProd(): ?int
    {
        return $this->idProd;
    }

    public function getIdCat(): ?int
    {
        return $this->idCat;
    }

    public function setIdCat(int $idCat): self
    {
        $this->idCat = $idCat;

        return $this;
    }

    public function getManuelProd(): ?string
    {
        return $this->manuelProd;
    }

    public function setManuelProd(string $manuelProd): self
    {
        $this->manuelProd = $manuelProd;

        return $this;
    }

    public function getInfosProd(): ?string
    {
        return $this->infosProd;
    }

    public function setInfosProd(string $infosProd): self
    {
        $this->infosProd = $infosProd;

        return $this;
    }

    public function isEffaceProd(): ?bool
    {
        return $this->effaceProd;
    }

    public function setEffaceProd(bool $effaceProd): self
    {
        $this->effaceProd = $effaceProd;

        return $this;
    }


}
