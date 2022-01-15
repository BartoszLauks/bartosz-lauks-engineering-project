<?php

namespace App\Entity;

use App\Repository\ModelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ModelRepository::class)
 * @UniqueEntity(fields={"name","brand"})
 */
class Model
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Generation::class, mappedBy="model")
     */
    private $generations;

    /**
     * @ORM\ManyToOne(targetEntity=Brand::class, inversedBy="models")
     * @Assert\NotBlank()
     */
    private $brand;

    /**
     * @ORM\OneToMany(targetEntity=SalesOffers::class, mappedBy="model")
     */
    private $salesOffers;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="model")
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity=SpecialistComment::class, mappedBy="model")
     */
    private $specialistComments;

    public function __construct()
    {
        $this->generations = new ArrayCollection();
        $this->salesOffers = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->specialistComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    /**
     * @return Collection|Generation[]
     */
    public function getGenerations(): Collection
    {
        return $this->generations;
    }

    public function addGeneration(Generation $generation): self
    {
        if (!$this->generations->contains($generation)) {
            $this->generations[] = $generation;
            $generation->setModel($this);
        }

        return $this;
    }

    public function removeGeneration(Generation $generation): self
    {
        if ($this->generations->removeElement($generation)) {
            // set the owning side to null (unless already changed)
            if ($generation->getModel() === $this) {
                $generation->setModel(null);
            }
        }

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @return Collection|SalesOffers[]
     */
    public function getSalesOffers(): Collection
    {
        return $this->salesOffers;
    }

    public function addSalesOffer(SalesOffers $salesOffer): self
    {
        if (!$this->salesOffers->contains($salesOffer)) {
            $this->salesOffers[] = $salesOffer;
            $salesOffer->setModel($this);
        }

        return $this;
    }

    public function removeSalesOffer(SalesOffers $salesOffer): self
    {
        if ($this->salesOffers->removeElement($salesOffer)) {
            // set the owning side to null (unless already changed)
            if ($salesOffer->getModel() === $this) {
                $salesOffer->setModel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setModel($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getModel() === $this) {
                $post->setModel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SpecialistComment[]
     */
    public function getSpecialistComments(): Collection
    {
        return $this->specialistComments;
    }

    public function addSpecialistComment(SpecialistComment $specialistComment): self
    {
        if (!$this->specialistComments->contains($specialistComment)) {
            $this->specialistComments[] = $specialistComment;
            $specialistComment->setModel($this);
        }

        return $this;
    }

    public function removeSpecialistComment(SpecialistComment $specialistComment): self
    {
        if ($this->specialistComments->removeElement($specialistComment)) {
            // set the owning side to null (unless already changed)
            if ($specialistComment->getModel() === $this) {
                $specialistComment->setModel(null);
            }
        }

        return $this;
    }
}
