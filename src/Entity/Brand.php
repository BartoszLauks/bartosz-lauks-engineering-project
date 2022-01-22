<?php

namespace App\Entity;

use App\Repository\BrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BrandRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("name")
 */
class Brand
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
     * @ORM\OneToMany(targetEntity=Model::class, mappedBy="brand")
     */
    private $models;

    /**
     * @ORM\OneToMany(targetEntity=SalesOffers::class, mappedBy="brand")
     */
    private $salesOffers;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="brand")
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity=SpecialistComment::class, mappedBy="brand")
     */
    private $specialistComments;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;


    public function __construct()
    {
        $this->models = new ArrayCollection();
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
     * @return Collection|Model[]
     */
    public function getModels(): Collection
    {
        return $this->models;
    }

    public function addModel(Model $model): self
    {
        if (!$this->models->contains($model)) {
            $this->models[] = $model;
            $model->setBrand($this);
        }

        return $this;
    }

    public function removeModel(Model $model): self
    {
        if ($this->models->removeElement($model)) {
            // set the owning side to null (unless already changed)
            if ($model->getBrand() === $this) {
                $model->setBrand(null);
            }
        }

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
            $salesOffer->setBrand($this);
        }

        return $this;
    }

    public function removeSalesOffer(SalesOffers $salesOffer): self
    {
        if ($this->salesOffers->removeElement($salesOffer)) {
            // set the owning side to null (unless already changed)
            if ($salesOffer->getBrand() === $this) {
                $salesOffer->setBrand(null);
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
            $post->setBrand($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getBrand() === $this) {
                $post->setBrand(null);
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
            $specialistComment->setBrand($this);
        }

        return $this;
    }

    public function removeSpecialistComment(SpecialistComment $specialistComment): self
    {
        if ($this->specialistComments->removeElement($specialistComment)) {
            // set the owning side to null (unless already changed)
            if ($specialistComment->getBrand() === $this) {
                $specialistComment->setBrand(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }
}
