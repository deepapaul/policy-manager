<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Controller\PolicyTargets;

/**
 * @ApiResource(
 *      collectionOperations={
 *          "post",
 *          "get",
 *          "get_policy_targets"={
 *              "method"="GET",
 *              "path"="/policies/{id}/targets",
 *              "controller"=PolicyTargets::class,
 *              "_api_swagger_context"={
 *                  "summary"="Get the targeted users of a policy.",
 *                  "parameters"={},
 *                  "responses"={
 *                      "200"={
 *                          "schema"={
 *                              "properties"={}
 *                          }
 *                      }
 *                  }
 *              }
 *          }
 *      },
 *      itemOperations={
 *          "get",
 *          "policy_new_version"={"method"="POST", "route_name"="policy_new_version"},
 *      }
 * 
 * )
 * @ORM\Entity(repositoryClass="App\Repository\PolicyRepository")
 * @UniqueEntity(
 *     fields={"name", "version"},
 *     errorPath="version",
 *     message="This version is already exists."
 * )
 *
 * @ORM\Table(
 *    name="policy", 
 *    uniqueConstraints={
 *        @ORM\UniqueConstraint(name="unique_policy", columns={"name", "version"})
 *    }
 * )
 *
 */
class Policy
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=6)
     */
    private $version = '1.0';

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $publishedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PolicyUsers", mappedBy="policy", orphanRemoval=true)
     */
    private $policyUsers;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isToAllUsers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PolicyFilter", mappedBy="policy")
     */
    private $policyFilters;

    public function __construct()
    {
        $this->policyUsers = new ArrayCollection();
        $this->policyFilters = new ArrayCollection();
    }

    public function getId(): ?int
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

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(string $version): self
    {
        $this->version = $version;

        return $this;
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

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getIsToAllUsers(): ?bool
    {
        return $this->isToAllUsers;
    }

    public function setIsToAllUsers(bool $isToAllUsers): self
    {
        $this->isToAllUsers = $isToAllUsers;

        return $this;
    }

    /**
     * @return Collection|PolicyUsers[]
     */
    public function getPolicyUsers(): Collection
    {
        return $this->policyUsers;
    }

    public function __clone()
    {
        list($major, $minor) = explode('.', $this->getVersion());
        $newVersion = sprintf("%d.%d", $major, ++$minor);
        $this->setVersion($newVersion);
    }

    /**
     * @return Collection|PolicyFilter[]
     */
    public function getPolicyFilters(): Collection
    {
        return $this->policyFilters;
    }

    public function addPolicyFilter(PolicyFilter $policyFilter): self
    {
        if (!$this->policyFilters->contains($policyFilter)) {
            $this->policyFilters[] = $policyFilter;
            $policyFilter->setPolicy($this);
        }

        return $this;
    }

    public function removePolicyFilter(PolicyFilter $policyFilter): self
    {
        if ($this->policyFilters->contains($policyFilter)) {
            $this->policyFilters->removeElement($policyFilter);
            // set the owning side to null (unless already changed)
            if ($policyFilter->getPolicy() === $this) {
                $policyFilter->setPolicy(null);
            }
        }

        return $this;
    }
}
