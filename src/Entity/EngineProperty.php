<?php

namespace App\Entity;

use App\Repository\EnginePropertyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EnginePropertyRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("name")
 */
class EngineProperty
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
    private $property;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=EngineValue::class, mappedBy="property")
     */
    private $engineValues;

    public function __construct()
    {
        $this->engineValues = new ArrayCollection();
        $this->carBodyValues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProperty(): ?string
    {
        return $this->property;
    }

    public function setProperty(string $property): self
    {
        $this->property = $property;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|EngineValue[]
     */
    public function getEngineValues(): Collection
    {
        return $this->engineValues;
    }

    public function addEngineValue(EngineValue $engineValue): self
    {
        if (!$this->engineValues->contains($engineValue)) {
            $this->engineValues[] = $engineValue;
            $engineValue->setProperty($this);
        }

        return $this;
    }

    public function removeEngineValue(EngineValue $engineValue): self
    {
        if ($this->engineValues->removeElement($engineValue)) {
            // set the owning side to null (unless already changed)
            if ($engineValue->getProperty() === $this) {
                $engineValue->setProperty(null);
            }
        }

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }

    public function __toString(): string
    {
        return $this->getProperty();
    }

}
