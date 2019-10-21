<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("email") * 
 * 
 * @ORM\Table(
 *    name="user", 
 *    uniqueConstraints={
 *        @ORM\UniqueConstraint(name="unique_email", columns={"email"})
 *    }
 * )
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastName;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Department", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $department;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Job", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $job;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PolicyUsers", mappedBy="user")
     */
    private $policyUsers;

    public function __construct()
    {
        $this->policyUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function getJob(): ?Job
    {
        return $this->job;
    }

    public function setJob(?Job $job): self
    {
        $this->job = $job;

        return $this;
    }

    /**
     * @return Collection|PolicyUsers[]
     */
    public function getPolicyUsers(): Collection
    {
        return $this->policyUsers;
    }

    public function addPolicyUser(PolicyUsers $policyUser): self
    {
        if (!$this->policyUsers->contains($policyUser)) {
            $this->policyUsers[] = $policyUser;
            $policyUser->setUser($this);
        }

        return $this;
    }

    public function removePolicyUser(PolicyUsers $policyUser): self
    {
        if ($this->policyUsers->contains($policyUser)) {
            $this->policyUsers->removeElement($policyUser);
            // set the owning side to null (unless already changed)
            if ($policyUser->getUser() === $this) {
                $policyUser->setUser(null);
            }
        }

        return $this;
    }
}
