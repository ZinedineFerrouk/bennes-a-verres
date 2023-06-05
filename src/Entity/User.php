<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(fields={"email"}, message="Un compte existe déjà avec ce email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $organization;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $kbis;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $user_token;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $api_access_token;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_validated;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|String 
     */
    public function getEmail(): ?String
    {
        return $this->email;
    }

    /**
     * @param String $email 
     * @return User 
     */
    public function setEmail(String $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): String
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): String
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param array $roles 
     * @return User 
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): String
    {
        return $this->password;
    }

    /**
     * @param String $password 
     * @return User 
     */
    public function setPassword(String $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?String
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return null|String 
     */
    public function getName(): ?String
    {
        return $this->name;
    }

    /**
     * @param null|String $name 
     * @return User 
     */
    public function setName(?String $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return null|String 
     */
    public function getFirstName(): ?String
    {
        return $this->first_name;
    }

    /**
     * @param null|String $first_name 
     * @return User 
     */
    public function setFirstName(?string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    /**
     * @return null|String 
     */
    public function getOrganization(): ?String
    {
        return $this->organization;
    }

    /**
     * @param null|String $organization 
     * @return User 
     */
    public function setOrganization(?String $organization): self
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * @return null|String 
     */
    public function getKbis(): ?String
    {
        return $this->kbis;
    }

    /**
     * @param null|String $kbis 
     * @return User 
     */
    public function setKbis(?String $kbis): self
    {
        $this->kbis = $kbis;

        return $this;
    }

    /**
     * @return null|String 
     */
    public function getPhone(): ?String
    {
        return $this->phone;
    }

    /**
     * @param String $phone 
     * @return User 
     */
    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return null|String 
     */
    public function getUserToken(): ?String
    {
        return $this->user_token;
    }

    /**
     * @param null|String $user_token 
     * @return User 
     */
    public function setUserToken(?String $user_token): self
    {
        $this->user_token = $user_token;

        return $this;
    }

    /**
     * @return null|String 
     */
    public function getApiAccessToken(): ?String
    {
        return $this->api_access_token;
    }

    /**
     * @param null|String $api_access_token 
     * @return User 
     */
    public function setApiAccessToken(?String $api_access_token): self
    {
        $this->api_access_token = $api_access_token;

        return $this;
    }

    /**
     * @return null|bool 
     */
    public function getIsValidated(): ?bool
    {
        return $this->is_validated;
    }

    /**
     * @param bool $is_validated 
     * @return User 
     */
    public function setIsValidated(bool $is_validated): self
    {
        $this->is_validated = $is_validated;

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
     * @return User 
     */
    public function setCreatedAt(): self
    {
        if ($this->created_at === null) {
            $this->created_at = new \DateTimeImmutable('now');
        }
        return $this;
    }
}
