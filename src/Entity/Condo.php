<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CondoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CondoRepository::class)]
#[ORM\Table(name: '`condo`')]
class Condo
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[ORM\Column(type: 'string', columnDefinition: 'CHAR(36) NOT NULL')]
    protected string $id;

    #[ORM\Column(type: 'string', length: 100)]
    private ?string$name;

    #[ORM\Column(type: 'string', length: 14, columnDefinition: 'CHAR(14) NOT NULL')]
    private ?string $taxCode;

    #[ORM\Column(type: 'boolean')]
    private ?bool $isActive;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTime $createdOn;

    public function __construct()
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->createdOn = new \DateTime();
    }

    public function getId(): ?string
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

    public function getTaxCode(): ?string
    {
        return $this->taxCode;
    }

    public function setTaxCode(string $taxCode): self
    {
        $this->taxCode = $taxCode;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getCreatedOn(): ?\DateTimeInterface
    {
        return $this->createdOn;
    }

    public function setCreatedOn(\DateTimeInterface $createdOn): self
    {
        $this->createdOn = $createdOn;

        return $this;
    }
}
