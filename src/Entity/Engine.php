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

    public function __construct()
    {
        $this->body = new ArrayCollection();
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
}
