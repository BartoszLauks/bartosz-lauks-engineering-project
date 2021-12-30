<?php

namespace App\Entity;

use App\Repository\SpecialistCommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SpecialistCommentRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"user","brand","model","generation","body","engine"}, message="You have already provided your comment for these components")
 */
class SpecialistComment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="specialistComments")
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Brand::class, inversedBy="specialistComments")
     * @Assert\NotBlank()
     */
    private $brand;

    /**
     * @ORM\ManyToOne(targetEntity=Model::class, inversedBy="specialistComments")
     * @Assert\NotBlank()
     */
    private $model;

    /**
     * @ORM\ManyToOne(targetEntity=Generation::class, inversedBy="specialistComments")
     * @Assert\NotBlank()
     */
    private $generation;

    /**
     * @ORM\ManyToOne(targetEntity=CarBody::class, inversedBy="specialistComments")
     * @Assert\NotBlank()
     */
    private $body;

    /**
     * @ORM\ManyToOne(targetEntity=Engine::class, inversedBy="specialistComments")
     * @Assert\NotBlank()
     */
    private $engine;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
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

    public function getBody(): ?CarBody
    {
        return $this->body;
    }

    public function setBody(?CarBody $body): self
    {
        $this->body = $body;

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

    /**
     * @ORM\PrePersist()
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }
}
