<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Utilisateurs
 *
 * @ORM\Table(name="utilisateurs", uniqueConstraints={@ORM\UniqueConstraint(name="mail_user", columns={"mail_user"})}, indexes={@ORM\Index(name="id_role", columns={"id_role"})})
 * @ORM\Entity
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
     */
    private $mailUser;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom_user", type="string", length=50, nullable=false)
     */
    private $Username;

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

    public function getUsername(): ?string
    {
        return $this->Username;
    }

    public function Username(string $Username): self
    {
        $this->Username = $Username;

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
}
