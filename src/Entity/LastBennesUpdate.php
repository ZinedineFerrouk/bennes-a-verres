<?php

namespace App\Entity;

use App\Repository\LastBennesUpdateRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LastBennesUpdateRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class LastBennesUpdate
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private $errored_update;

    /**
     * @return null|int 
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|DateTimeImmutable 
     */
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    /**
     * @ORM\PrePersist
     * @return LastBennesUpdate 
     */
    public function setUpdatedAt(): self
    {
        if ($this->updated_at === null) {
            $this->updated_at = new \DateTimeImmutable('now');
        }
        return $this;
    }

    /**
     * @return null|bool 
     */
    public function getErroredUpdate(): ?bool
    {
        return $this->errored_update;
    }

    /**
     * @param bool $errored_update 
     * @return LastBennesUpdate 
     */
    public function setErroredUpdate(bool $errored_update): self
    {
        $this->errored_update = $errored_update;

        return $this;
    }
}
