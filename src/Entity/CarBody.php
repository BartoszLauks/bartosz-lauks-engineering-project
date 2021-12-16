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

    public function __construct()
    {
        $this->engines = new ArrayCollection();
        $this->value = new ArrayCollection();
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

}
