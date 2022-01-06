<?php

namespace App\Entity;

use App\Repository\CarBodyValueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CarBodyValueRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class CarBodyValue
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
    private $value;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=CarBody::class, inversedBy="value")
     */
    private $carBody;

    /**
     * @ORM\ManyToOne(targetEntity=CarBodyProperty::class, inversedBy="carBodyValues")
     */
    private $property;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

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

    public function getCarBody(): ?CarBody
    {
        return $this->carBody;
    }

    public function setCarBody(?CarBody $carBody): self
    {
        $this->carBody = $carBody;

        return $this;
    }

    public function getProperty(): ?CarBodyProperty
    {
        return $this->property;
    }

    public function setProperty(?CarBodyProperty $property): self
    {
        $this->property = $property;

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
        return $this->getValue();
    }
}
