<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CondoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'condos')]
    private Collection $users;

    public function __construct()
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->createdOn = new \DateTime();
        $this->users = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTaxCode(): ?string
    {
        return $this->taxCode;
    }

    /**
     * @throws \Exception
     */
    public function setTaxCode(?string $taxCode): void
    {
        if (!$this->validate_cnpj($taxCode)) {
            throw new \Exception('CNPJ invalid');
        }

        $this->taxCode = $this->normalize($taxCode);
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function toggleActive(): void
    {
        $this->isActive = !$this->isActive;
    }

    public function getCreatedOn(): \DateTime
    {
        return $this->createdOn;
    }

    #[ORM\PrePersist]
    private function setCreationDatetime(): void
    {
        $this->createdOn = new \DateTime();
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection|null
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addCondo($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeCondo($this);
        }

        return $this;
    }

    public function containsUser(User $user): bool
    {
        return $this->users->contains($user);
    }

    public function __toString(): string
    {
        return $this->cnpj;
    }

    private function normalize(string $value): string
    {
        return preg_replace('/[^0-9]/', '', (string) $value);
    }

    private function validate_cnpj($cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);

        // Valida tamanho
        if (strlen($cnpj) != 14)
            return false;

        // Verifica se todos os digitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj))
            return false;

        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
        {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
            return false;

        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
        {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
    }
}
