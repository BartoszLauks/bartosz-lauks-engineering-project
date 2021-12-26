<?php

namespace App\Entity;

use App\Repository\SalesOffersRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SalesOffersRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class SalesOffers
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Brand::class, inversedBy="salesOffers")
     */
    private $brand;

    /**
     * @ORM\ManyToOne(targetEntity=Model::class, inversedBy="salesOffers")
     */
    private $model;

    /**
     * @ORM\ManyToOne(targetEntity=Generation::class, inversedBy="salesOffers")
     */
    private $generation;

    /**
     * @ORM\ManyToOne(targetEntity=CarBody::class, inversedBy="salesOffers")
     */
    private $carBody;

    /**
     * @ORM\ManyToOne(targetEntity=Engine::class, inversedBy="salesOffers")
     */
    private $engine;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="salesOffers")
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $mileage;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $details;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $file;

    /**
     * @ORM\Column(type="date")
     */
    private $producedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function setModel(?Model $model): self
    {
        $this->model = $model;

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

    public function getCarBody(): ?CarBody
    {
        return $this->carBody;
    }

    public function setCarBody(?CarBody $carBody): self
    {
        $this->carBody = $carBody;

        return $this;
    }

    public function getEngine(): ?Engine
    {
        return $this->engine;
    }

    public function setEngine(?Engine $engine): self
    {
        $this->engine = $engine;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getMileage(): ?int
    {
        return $this->mileage;
    }

    public function setMileage(int $mileage): self
    {
        $this->mileage = $mileage;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): self
    {
        $this->details = $details;

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
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getProducedAt(): ?\DateTimeInterface
    {
        return $this->producedAt;
    }

    public function setProducedAt(\DateTimeInterface $producedAt): self
    {
        $this->producedAt = $producedAt;

        return $this;
    }
}
