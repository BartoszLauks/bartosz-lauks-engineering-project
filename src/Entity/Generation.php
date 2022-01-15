<?php

namespace App\Entity;

use App\Repository\GenerationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=GenerationRepository::class)
 * @UniqueEntity(fields={"name","model"})
 */
class Generation
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
     * @Groups({"new_car"})
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=CarBody::class, mappedBy="generation")
     */
    private $carBodies;

    /**
     * @ORM\ManyToOne(targetEntity=Model::class, inversedBy="generations")
     * @Assert\NotBlank()
     */
    private $model;

    /**
     * @ORM\OneToMany(targetEntity=SalesOffers::class, mappedBy="generation")
     * @Assert\NotBlank()
     */
    private $salesOffers;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="generation")
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity=SpecialistComment::class, mappedBy="generation")
     */
    private $specialistComments;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\PositiveOrZero()
     * @Groups({"new_car"})
     */
    private $producedFrom;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\PositiveOrZero()
     * @Groups({"new_car"})
     */
    private $producedUntil;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex(
     *     pattern="/^.*\.(jpg|jpeg|png|gif)$/i",
     *     match=true,
     *     message="You cannot add a file other than a photo"
     * )
     * @Groups({"new_car"})
     */
    private $file;

    public function __construct()
    {
        $this->carBodies = new ArrayCollection();
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
     * @return Collection|CarBody[]
     */
    public function getCarBodies(): Collection
    {
        return $this->carBodies;
    }

    public function addCarBody(CarBody $carBody): self
    {
        if (!$this->carBodies->contains($carBody)) {
            $this->carBodies[] = $carBody;
            $carBody->setGeneration($this);
        }

        return $this;
    }

    public function removeCarBody(CarBody $carBody): self
    {
        if ($this->carBodies->removeElement($carBody)) {
            // set the owning side to null (unless already changed)
            if ($carBody->getGeneration() === $this) {
                $carBody->setGeneration(null);
            }
        }

        return $this;
    }

    public function getModel(): ?model
    {
        return $this->model;
    }

    public function setModel(?model $model): self
    {
        $this->model = $model;

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
            $salesOffer->setGeneration($this);
        }

        return $this;
    }

    public function removeSalesOffer(SalesOffers $salesOffer): self
    {
        if ($this->salesOffers->removeElement($salesOffer)) {
            // set the owning side to null (unless already changed)
            if ($salesOffer->getGeneration() === $this) {
                $salesOffer->setGeneration(null);
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
            $post->setGeneration($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getGeneration() === $this) {
                $post->setGeneration(null);
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
            $specialistComment->setGeneration($this);
        }

        return $this;
    }

    public function removeSpecialistComment(SpecialistComment $specialistComment): self
    {
        if ($this->specialistComments->removeElement($specialistComment)) {
            // set the owning side to null (unless already changed)
            if ($specialistComment->getGeneration() === $this) {
                $specialistComment->setGeneration(null);
            }
        }

        return $this;
    }

    public function getProducedFrom(): ?int
    {
        return $this->producedFrom;
    }

    public function setProducedFrom(int $producedFrom): self
    {
        $this->producedFrom = $producedFrom;

        return $this;
    }

    public function getProducedUntil(): ?int
    {
        return $this->producedUntil;
    }

    public function setProducedUntil(int $producedUntil): self
    {
        $this->producedUntil = $producedUntil;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(?string $file): self
    {
        $this->file = $file;

        return $this;
    }
}
