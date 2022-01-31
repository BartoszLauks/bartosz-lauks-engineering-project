<?php

namespace App\Entity;

use App\Repository\CarBodyPropertyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CarBodyPropertyRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("property")
 */
class CarBodyProperty
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
     * @ORM\OneToMany(targetEntity=CarBodyValue::class, mappedBy="property")
     */
    private $carBodyValues;

    public function __construct()
    {
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
     * @return Collection|CarBodyValue[]
     */
    public function getCarBodyValues(): Collection
    {
        return $this->carBodyValues;
    }

    public function addCarBodyValue(CarBodyValue $carBodyValue): self
    {
        if (!$this->carBodyValues->contains($carBodyValue)) {
            $this->carBodyValues[] = $carBodyValue;
            $carBodyValue->setProperty($this);
        }

        return $this;
    }

    public function removeCarBodyValue(CarBodyValue $carBodyValue): self
    {
        if ($this->carBodyValues->removeElement($carBodyValue)) {
            // set the owning side to null (unless already changed)
            if ($carBodyValue->getProperty() === $this) {
                $carBodyValue->setProperty(null);
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
