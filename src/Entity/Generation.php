<?php

namespace App\Entity;

use App\Repository\GenerationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GenerationRepository::class)
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
     * @ORM\ManyToOne(targetEntity=model::class, inversedBy="generations")
     */
    private $model;

    public function __construct()
    {
        $this->carBodies = new ArrayCollection();
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
}
