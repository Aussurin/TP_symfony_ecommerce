<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2, nullable: true)]
    private ?string $prix = null;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: LigneCommande::class)]
    private Collection $lignesCommandes;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    public function __construct()
    {
        $this->lignesCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(?string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection<int, LigneCommande>
     */
    public function getLignesCommandes(): Collection
    {
        return $this->lignesCommandes;
    }

    public function addLignesCommande(LigneCommande $lignesCommande): self
    {
        if (!$this->lignesCommandes->contains($lignesCommande)) {
            $this->lignesCommandes->add($lignesCommande);
            $lignesCommande->setProduit($this);
        }

        return $this;
    }

    public function removeLignesCommande(LigneCommande $lignesCommande): self
    {
        if ($this->lignesCommandes->removeElement($lignesCommande)) {
            // set the owning side to null (unless already changed)
            if ($lignesCommande->getProduit() === $this) {
                $lignesCommande->setProduit(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
