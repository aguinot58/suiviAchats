<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produits
 *
 * @ORM\Table(name="produits", indexes={@ORM\Index(name="id_cat", columns={"id_cat"})})
 * @ORM\Entity
 * @ORM\Table(name="produits", indexes={@ORM\Index(columns={"nom_prod", "infos_prod"}, flags={"fulltext"})})
 * @ORM\Entity(repositoryClass="App\Repository\ProduitsRepository")
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
     * @var string
     *
     * @ORM\Column(name="nom_prod", type="string", length=100, nullable=false)
     */
    private $nomProd;

    /**
     * @var string
     *
     * @ORM\Column(name="manuel_prod", type="string", length=255, nullable=true)
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

    /**
     * @var \Categories
     *
     * @ORM\ManyToOne(targetEntity="Categories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cat", referencedColumnName="id_cat")
     * })
     */
    private $idCat;

    public function getIdProd(): ?int
    {
        return $this->idProd;
    }

    public function getNomProd(): ?string
    {
        return $this->nomProd;
    }

    public function setNomProd(string $nomProd): self
    {
        $this->nomProd = $nomProd;

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

    public function getIdCat(): ?Categories
    {
        return $this->idCat;
    }

    public function setIdCat(?Categories $idCat): self
    {
        $this->idCat = $idCat;

        return $this;
    }

    public function __toString()
    {
        return $this->nomProd;
    }
}
