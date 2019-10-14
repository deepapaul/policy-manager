<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\PolicyFilterRepository")
 */
class PolicyFilter
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $policy;

    /**
     * @ORM\Column(type="json_array")
     */
    private $filter = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private $allUsers;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPolicy(): ?int
    {
        return $this->policy;
    }

    public function setPolicy(int $policy): self
    {
        $this->policy = $policy;

        return $this;
    }

    public function getFilter(): ?array
    {
        return $this->filter;
    }

    public function setFilter(array $filter): self
    {
        $this->filter = $filter;

        return $this;
    }

    public function getAllUsers(): ?bool
    {
        return $this->allUsers;
    }

    public function setAllUsers(bool $allUsers): self
    {
        $this->allUsers = $allUsers;

        return $this;
    }
}
