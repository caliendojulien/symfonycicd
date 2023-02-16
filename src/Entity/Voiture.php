<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
class Voiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['voitures'])]
    private ?string $marque = null;

    #[ORM\Column(length: 255)]
    #[Groups(['voitures'])]
    private ?string $modele = null;

    #[ORM\ManyToMany(targetEntity: Proprietaire::class, mappedBy: 'voitures')]
    #[Groups(['voitures'])]
    private Collection $proprietaires;

    public function __construct()
    {
        $this->proprietaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    /**
     * @return Collection<int, Proprietaire>
     */
    public function getProprietaires(): Collection
    {
        return $this->proprietaires;
    }

    public function addProprietaire(Proprietaire $proprietaire): self
    {
        if (!$this->proprietaires->contains($proprietaire)) {
            $this->proprietaires->add($proprietaire);
            $proprietaire->addVoiture($this);
        }

        return $this;
    }

    public function removeProprietaire(Proprietaire $proprietaire): self
    {
        if ($this->proprietaires->removeElement($proprietaire)) {
            $proprietaire->removeVoiture($this);
        }

        return $this;
    }
}
