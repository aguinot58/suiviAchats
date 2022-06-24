<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Achats
 *
 * @ORM\Table(name="achats", indexes={@ORM\Index(name="id_user", columns={"id_user"}), @ORM\Index(name="id_prod", columns={"id_prod"}), @ORM\Index(name="id_type_lieu", columns={"id_type_lieu"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\AchatsRepository")
 */
class Achats
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_achat", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAchat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_achat", type="date", nullable=false)
     */
    private $dateAchat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_gar_achat", type="date", nullable=false)
     */
    private $dateGarAchat;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_achat", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixAchat;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_ticket_achat", type="string", length=255, nullable=false)
     */
    private $photoTicketAchat;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu_achat", type="string", length=255, nullable=false)
     */
    private $lieuAchat;

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

    /**
     * @var \TypeLieux
     *
     * @ORM\ManyToOne(targetEntity="TypeLieux")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_type_lieu", referencedColumnName="id_type_lieu")
     * })
     */
    private $idTypeLieu;

    public function getIdAchat(): ?int
    {
        return $this->idAchat;
    }

    public function getDateAchat(): ?\DateTimeInterface
    {
        return $this->dateAchat;
    }

    public function setDateAchat(\DateTimeInterface $dateAchat): self
    {
        $this->dateAchat = $dateAchat;

        return $this;
    }

    public function getDateGarAchat(): ?\DateTimeInterface
    {
        return $this->dateGarAchat;
    }

    public function setDateGarAchat(\DateTimeInterface $dateGarAchat): self
    {
        $this->dateGarAchat = $dateGarAchat;

        return $this;
    }

    public function getPrixAchat(): ?float
    {
        return $this->prixAchat;
    }

    public function setPrixAchat(float $prixAchat): self
    {
        $this->prixAchat = $prixAchat;

        return $this;
    }

    public function getPhotoTicketAchat(): ?string
    {
        return $this->photoTicketAchat;
    }

    public function setPhotoTicketAchat(string $photoTicketAchat): self
    {
        $this->photoTicketAchat = $photoTicketAchat;

        return $this;
    }

    public function getLieuAchat(): ?string
    {
        return $this->lieuAchat;
    }

    public function setLieuAchat(string $lieuAchat): self
    {
        $this->lieuAchat = $lieuAchat;

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

    public function getIdTypeLieu(): ?TypeLieux
    {
        return $this->idTypeLieu;
    }

    public function setIdTypeLieu(?TypeLieux $idTypeLieu): self
    {
        $this->idTypeLieu = $idTypeLieu;

        return $this;
    }


}
