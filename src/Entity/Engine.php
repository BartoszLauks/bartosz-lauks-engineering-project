<?php

namespace App\Entity;

use App\Repository\EngineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EngineRepository::class)
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
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=CarBody::class, inversedBy="engines")
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

    public function __construct()
    {
        $this->body = new ArrayCollection();
        $this->value = new ArrayCollection();
        $this->salesOffers = new ArrayCollection();
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
}
