<?php

namespace App\Entity;

use App\Repository\BenneRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;


/**
 * @ORM\Entity(repositoryClass=BenneRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Benne
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $recordid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $commune;

    /**
     * @ORM\Column(type="float")
     */
    private $quartier;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $model;

    /**
     * @ORM\Column(type="float")
     */
    private $latitude;

    /**
     * @ORM\Column(type="float")
     */
    private $longitude;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    public function __construct()
    {
        $this->id = Uuid::v4();
    }

    /**
     * @return null|Uuid 
     */
    public function getId(): ?Uuid
    {
        return $this->id;
    }

    /**
     * @return null|String 
     */
    public function getRecordid(): ?String
    {
        return $this->recordid;
    }

    /**
     * @param String $recordid 
     * @return Benne 
     */
    public function setRecordid(String $recordid): self
    {
        $this->recordid = $recordid;

        return $this;
    }

    /**
     * @return null|String 
     */
    public function getAddress(): ?String
    {
        return $this->address;
    }

    /**
     * @param String $address 
     * @return Benne 
     */
    public function setAddress(String $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return null|String 
     */
    public function getCommune(): ?String
    {
        return $this->commune;
    }

    /**
     * @param String $commune 
     * @return Benne 
     */
    public function setCommune(String $commune): self
    {
        $this->commune = $commune;

        return $this;
    }

    /**
     * @return null|float 
     */
    public function getQuartier(): ?float
    {
        return $this->quartier;
    }

    /**
     * @param float $quartier 
     * @return Benne 
     */
    public function setQuartier(float $quartier): self
    {
        $this->quartier = $quartier;

        return $this;
    }

    /**
     * @return null|String 
     */
    public function getModel(): ?String
    {
        return $this->model;
    }

    /**
     * @param String $model 
     * @return Benne 
     */
    public function setModel(String $model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return null|float 
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude 
     * @return Benne 
     */
    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return null|float 
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude 
     * @return Benne 
     */
    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return null|DateTimeImmutable 
     */
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    /**
     * @ORM\PrePersist
     * @return Benne 
     */
    public function setCreatedAt(): self
    {
        if ($this->created_at === null) {
            $this->created_at = new \DateTimeImmutable('now');
        }
        return $this;
    }
}
