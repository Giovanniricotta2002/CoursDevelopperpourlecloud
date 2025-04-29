<?php

namespace App\Entity;

use App\Enum\Status;
use App\Repository\LicencesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LicencesRepository::class)]
class Licences
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $tenant = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $clientId = null;

    #[ORM\Column(length: 100)]
    private ?string $api_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $licence_key = null;

    #[ORM\Column(enumType: Status::class, length: 100)]
    private ?Status $status = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $creationDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $expirationDate = null;

    #[ORM\Column]
    private ?int $usageLimite = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    private ?string $usageCount = null;

    #[ORM\Column]
    private ?int $rateLimit = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $lastUsedAt = null;

    #[ORM\Column(type: Types::GUID)]
    private ?string $createdBy = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTenant(): ?string
    {
        return $this->tenant;
    }

    public function setTenant(string $tenant): static
    {
        $this->tenant = $tenant;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getClientId(): ?int
    {
        return $this->clientId;
    }

    public function setClientId(?int $clientId): static
    {
        $this->clientId = $clientId;

        return $this;
    }

    public function getApiName(): ?string
    {
        return $this->api_name;
    }

    public function setApiName(string $api_name): static
    {
        $this->api_name = $api_name;

        return $this;
    }

    public function getLicenceKey(): ?string
    {
        return $this->licence_key;
    }

    public function setLicenceKey(?string $licence_key): static
    {
        $this->licence_key = $licence_key;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreationDate(): ?\DateTime
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTime $creationDate): static
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getExpirationDate(): ?\DateTime
    {
        return $this->expirationDate;
    }

    public function setExpirationDate(\DateTime $expirationDate): static
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    public function getUsageLimite(): ?int
    {
        return $this->usageLimite;
    }

    public function setUsageLimite(int $usageLimite): static
    {
        $this->usageLimite = $usageLimite;

        return $this;
    }

    public function getUsageCount(): ?string
    {
        return $this->usageCount;
    }

    public function setUsageCount(?string $usageCount): static
    {
        $this->usageCount = $usageCount;

        return $this;
    }

    public function getRateLimit(): ?int
    {
        return $this->rateLimit;
    }

    public function setRateLimit(int $rateLimit): static
    {
        $this->rateLimit = $rateLimit;

        return $this;
    }

    public function getLastUsedAt(): ?\DateTimeImmutable
    {
        return $this->lastUsedAt;
    }

    public function setLastUsedAt(?\DateTimeImmutable $lastUsedAt): static
    {
        $this->lastUsedAt = $lastUsedAt;

        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function setCreatedBy(string $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
