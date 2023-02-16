<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdresseRepository::class)]
class Adresse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\ManyToMany(targetEntity: Proprietaire::class, inversedBy: 'adresses')]
    private Collection $proprietaire;

    public function __construct()
    {
        $this->proprietaire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * @return Collection<int, Proprietaire>
     */
    public function getProprietaire(): Collection
    {
        return $this->proprietaire;
    }

    public function addProprietaire(Proprietaire $proprietaire): self
    {
        if (!$this->proprietaire->contains($proprietaire)) {
            $this->proprietaire->add($proprietaire);
        }

        return $this;
    }

    public function removeProprietaire(Proprietaire $proprietaire): self
    {
        $this->proprietaire->removeElement($proprietaire);

        return $this;
    }
}
