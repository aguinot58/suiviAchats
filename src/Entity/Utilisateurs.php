<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Utilisateurs
 *
 * @ORM\Table(name="utilisateurs", uniqueConstraints={@ORM\UniqueConstraint(name="mail_user", columns={"mail_user"})}, indexes={@ORM\Index(name="id_role", columns={"id_role"})})
 * @ORM\Entity
 * @UniqueEntity(
 * fields={"mailUser"},
 * message= "L'email que vous avez indiquer est déjà utilisé"
 * )
 */
class Utilisateurs implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_user", type="string", length=255, nullable=false)
     * @Assert\Email()
     */
    private $mailUser;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom_user", type="string", length=50, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_user", type="string", length=50, nullable=false)
     */
    private $surName;



    /**
     * @var string
     *
     * @ORM\Column(name="mdp_user", type="string", length=255, nullable=false)
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit faire minimum 8 caractères")
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="Votre mot de passe doit être le même")
     */

    public $confirmMdp;
    
    /**
     * @var \Roles
     *
     * @ORM\ManyToOne(targetEntity="Roles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_role", referencedColumnName="id_role")
     * })
     */
    private $idRole;

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function getsurName(): ?string
    {
        return $this->surName;
    }

    public function setsurName(string $surName): self
    {
        $this->surName = $surName;

        return $this;
    }

    public function getusername(): ?string
    {
        return $this->username;
    }

    public function setusername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getMailUser(): ?string
    {
        return $this->mailUser;
    }

    public function setMailUser(string $mailUser): self
    {
        $this->mailUser = $mailUser;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getIdRole(): ?Roles
    {
        
        return $this->idRole;
    }

    public function setIdRole(?Roles $idRole): self
    {
        
        $this->idRole = $idRole;

        return $this;
    }

    public function eraseCredentials()
    {   
    }

    public function getSalt()
    {
    }

    public function getRoles(){
        return ['ROLE_USER'];
    }

    public function __toString()
    {
        return $this->mailUser;
    }

}
