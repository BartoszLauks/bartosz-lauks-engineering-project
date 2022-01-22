<?php

namespace App\Entity;

use App\Repository\EngineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EngineRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"name","body"})
 */
class Engine
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
     * @ORM\ManyToMany(targetEntity=CarBody::class, inversedBy="engines")
     * @Assert\NotBlank()
     */
    private $body;

    /**
     * @ORM\OneToMany(targetEntity=EngineValue::class, mappedBy="engine")
     */
    private $value;

    /**
     * @ORM\OneToMany(targetEntity=SalesOffers::class, mappedBy="engine")
     */
    private $salesOffers;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="engine")
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity=SpecialistComment::class, mappedBy="engine")
     */
    private $specialistComments;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    public function __construct()
    {
        $this->body = new ArrayCollection();
        $this->value = new ArrayCollection();
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
    public function getBody(): Collection
    {
        return $this->body;
    }

    public function addBody(CarBody $body): self
    {
        if (!$this->body->contains($body)) {
            $this->body[] = $body;
        }

        return $this;
    }

    public function removeBody(CarBody $body): self
    {
        $this->body->removeElement($body);

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @return Collection|EngineValue[]
     */
    public function getValue(): Collection
    {
        return $this->value;
    }

    public function addValue(EngineValue $value): self
    {
        if (!$this->value->contains($value)) {
            $this->value[] = $value;
            $value->setEngine($this);
        }

        return $this;
    }

    public function removeValue(EngineValue $value): self
    {
        if ($this->value->removeElement($value)) {
            // set the owning side to null (unless already changed)
            if ($value->getEngine() === $this) {
                $value->setEngine(null);
            }
        }

        return $this;
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
            $salesOffer->setEngine($this);
        }

        return $this;
    }

    public function removeSalesOffer(SalesOffers $salesOffer): self
    {
        if ($this->salesOffers->removeElement($salesOffer)) {
            // set the owning side to null (unless already changed)
            if ($salesOffer->getEngine() === $this) {
                $salesOffer->setEngine(null);
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
            $post->setEngine($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getEngine() === $this) {
                $post->setEngine(null);
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
            $specialistComment->setEngine($this);
        }

        return $this;
    }

    public function removeSpecialistComment(SpecialistComment $specialistComment): self
    {
        if ($this->specialistComments->removeElement($specialistComment)) {
            // set the owning side to null (unless already changed)
            if ($specialistComment->getEngine() === $this) {
                $specialistComment->setEngine(null);
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
