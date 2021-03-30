<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PanierRepository::class)
 */
class Panier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateurs::class, inversedBy="paniers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idU;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\ManyToOne(targetEntity=TreeTrunk::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $idP;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdU(): ?Utilisateurs
    {
        return $this->idU;
    }

    public function setIdU(?Utilisateurs $idU): self
    {
        $this->idU = $idU;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getIdP(): ?TreeTrunk
    {
        return $this->idP;
    }

    public function setIdP(?TreeTrunk $idP): self
    {
        $this->idP = $idP;

        return $this;
    }
}
