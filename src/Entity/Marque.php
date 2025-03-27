<?php

namespace App\Entity;

use App\Repository\MarqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarqueRepository::class)]
class Marque
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'Marque')]
    private Collection $LesProduits;

    #[ORM\Column(length: 255,nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $imageFileName = null;

    public function __construct()
    {
        $this->LesProduits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getLesProduits(): Collection
    {
        return $this->LesProduits;
    }

    public function addLesProduit(Produit $lesProduit): static
    {
        if (!$this->LesProduits->contains($lesProduit)) {
            $this->LesProduits->add($lesProduit);
            $lesProduit->setMarque($this);
        }

        return $this;
    }

    public function removeLesProduit(Produit $lesProduit): static
    {
        if ($this->LesProduits->removeElement($lesProduit)) {
            // set the owning side to null (unless already changed)
            if ($lesProduit->getMarque() === $this) {
                $lesProduit->setMarque(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getImageFileName(): ?string
    {
        return $this->imageFileName;
    }

    public function setImageFileName(string $imageFileName): static
    {
        $this->imageFileName = $imageFileName;

        return $this;
    }
}
