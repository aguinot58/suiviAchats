<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modifications
 *
 * @ORM\Table(name="modifications", indexes={@ORM\Index(name="id_user", columns={"id_user"}), @ORM\Index(name="id_prod", columns={"id_prod"})})
 * @ORM\Entity
 */
class Modifications
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_modif", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idModif;

    /**
     * @var string
     *
     * @ORM\Column(name="type_modif", type="string", length=10, nullable=false)
     */
    private $typeModif;

    /**
     * @var string
     *
     * @ORM\Column(name="desc_modif", type="string", length=500, nullable=false)
     */
    private $descModif;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modif", type="date", nullable=false)
     */
    private $dateModif;

    /**
     * @var \Produits
     *
     * @ORM\ManyToOne(targetEntity="Produits")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_prod", referencedColumnName="id_prod")
     * })
     */
    private $idProd;

    /**
     * @var \Utilisateurs
     *
     * @ORM\ManyToOne(targetEntity="Utilisateurs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    public function getIdModif(): ?int
    {
        return $this->idModif;
    }

    public function getTypeModif(): ?string
    {
        return $this->typeModif;
    }

    public function setTypeModif(string $typeModif): self
    {
        $this->typeModif = $typeModif;

        return $this;
    }

    public function getDescModif(): ?string
    {
        return $this->descModif;
    }

    public function setDescModif(string $descModif): self
    {
        $this->descModif = $descModif;

        return $this;
    }

    public function getDateModif(): ?\DateTimeInterface
    {
        return $this->dateModif;
    }

    public function setDateModif(\DateTimeInterface $dateModif): self
    {
        $this->dateModif = $dateModif;

        return $this;
    }

    public function getIdProd(): ?Produits
    {
        return $this->idProd;
    }

    public function setIdProd(?Produits $idProd): self
    {
        $this->idProd = $idProd;

        return $this;
    }

    public function getIdUser(): ?Utilisateurs
    {
        return $this->idUser;
    }

    public function setIdUser(?Utilisateurs $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }


}
