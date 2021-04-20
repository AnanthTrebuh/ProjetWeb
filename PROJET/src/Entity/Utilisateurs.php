<?php

namespace App\Entity;

use App\Repository\UtilisateursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Table (name="im2021_utilisateurs")
 * @ORM\Entity(repositoryClass=UtilisateursRepository::class)
 * @UniqueEntity(
 *     fields={"identifiant"},
 *     message="Identifiant déjà pris !"
 * )
 */
class Utilisateurs
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name ="pk", type="integer")
     *
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30, options={"comment"= "sert de login (doit être unique)"})
     * @Assert\NotBlank()
     */
    private $identifiant;

    /**
     * @ORM\Column(type="string", length=64, options={"comment"= "mot de passe crypté : il faut une taille assez grande pour ne pas le tronquer"})
     * @Assert\NotBlank()
     */
    private $motdepasse;


    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     * @Assert\NotBlank (message="Doit être rempli")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     * @Assert\NotBlank (message="Doit être rempli")
     */
    private $prenom;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\NotBlank (message="Doit être rempli")
     */
    private $anniversaire;

    /**
     * @ORM\Column(type="boolean", options={"comment"= "type boolean"})
     */
    private $isadmin;

    /**
     * @ORM\ManyToOne (targetEntity=Panier::class, inversedBy="idU")
     */
    private $paniers;

    public function __construct()
    {
        $this->paniers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentifiant(): ?string
    {
        return $this->identifiant;
    }

    public function setIdentifiant(string $identifiant): self
    {
        $this->identifiant = $identifiant;

        return $this;
    }

    public function getMotdepasse(): ?string
    {
        return $this->motdepasse;
    }

    public function setMotdepasse(string $motdepasse): self
    {
        $this->motdepasse = $motdepasse;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAnniversaire(): ?\DateTimeInterface
    {
        return $this->anniversaire;
    }

    public function setAnniversaire(?\DateTimeInterface $anniversaire): self
    {
        $this->anniversaire = $anniversaire;

        return $this;
    }

    public function getIsadmin(): ?bool
    {
        return $this->isadmin;
    }

    public function setIsadmin(bool $isadmin): self
    {
        $this->isadmin = $isadmin;

        return $this;
    }

    /**
     * @return Collection|Panier[]
     */
    public function getPaniers(): Collection
    {
        return $this->paniers;
    }

    public function addPanier(Panier $panier): self
    {
        if (!$this->paniers->contains($panier)) {
            $this->paniers[] = $panier;
            $panier->setIdU($this);
        }

        return $this;
    }

    public function removePanier(Panier $panier): self
    {
        if ($this->paniers->removeElement($panier)) {
            // set the owning side to null (unless already changed)
            if ($panier->getIdU() === $this) {
                $panier->setIdU(null);
            }
        }

        return $this;
    }
}
