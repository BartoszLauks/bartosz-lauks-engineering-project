<?php

namespace App\Entity;

use App\Repository\CarBodyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CarBodyRepository::class)
 */
class CarBody
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Engine::class, mappedBy="body")
     */
    private $engines;

    /**
     * @ORM\ManyToOne(targetEntity=Generation::class, inversedBy="carBodies")
     */
    private $generation;

    /**
     * @ORM\OneToMany(targetEntity=CarBodyValue::class, mappedBy="carBody")
     */
    private $value;

    /**
     * @ORM\OneToMany(targetEntity=SalesOffers::class, mappedBy="carBody")
     */
    private $salesOffers;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="carBody")
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity=SpecialistComment::class, mappedBy="body")
     */
    private $specialistComments;

    public function __construct()
    {
        $this->engines = new ArrayCollection();
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
     * @return Collection|Engine[]
     */
    public function getEngines(): Collection
    {
        return $this->engines;
    }

    public function addEngine(Engine $engine): self
    {
        if (!$this->engines->contains($engine)) {
            $this->engines[] = $engine;
            $engine->addBody($this);
        }

        return $this;
    }

    public function removeEngine(Engine $engine): self
    {
        if ($this->engines->removeElement($engine)) {
            $engine->removeBody($this);
        }

        return $this;
    }

    public function getGeneration(): ?Generation
    {
        return $this->generation;
    }

    public function setGeneration(?Generation $generation): self
    {
        $this->generation = $generation;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @return Collection|CarBodyValue[]
     */
    public function getValue(): Collection
    {
        return $this->value;
    }

    public function addValue(CarBodyValue $value): self
    {
        if (!$this->value->contains($value)) {
            $this->value[] = $value;
            $value->setCarBody($this);
        }

        return $this;
    }

    public function removeValue(CarBodyValue $value): self
    {
        if ($this->value->removeElement($value)) {
            // set the owning side to null (unless already changed)
            if ($value->getCarBody() === $this) {
                $value->setCarBody(null);
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
            $salesOffer->setCarBody($this);
        }

        return $this;
    }

    public function removeSalesOffer(SalesOffers $salesOffer): self
    {
        if ($this->salesOffers->removeElement($salesOffer)) {
            // set the owning side to null (unless already changed)
            if ($salesOffer->getCarBody() === $this) {
                $salesOffer->setCarBody(null);
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
            $post->setCarBody($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getCarBody() === $this) {
                $post->setCarBody(null);
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
            $specialistComment->setBody($this);
        }

        return $this;
    }

    public function removeSpecialistComment(SpecialistComment $specialistComment): self
    {
        if ($this->specialistComments->removeElement($specialistComment)) {
            // set the owning side to null (unless already changed)
            if ($specialistComment->getBody() === $this) {
                $specialistComment->setBody(null);
            }
        }

        return $this;
    }

}
