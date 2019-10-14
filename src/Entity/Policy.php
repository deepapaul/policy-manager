<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Version\Version;

/**
 * @ApiResource(
 *      collectionOperations={
 *          "post",
 *          "get"
 *      },
 *      itemOperations={
 *          "get",
 *          "get_policy_users"={"method"="get", "route_name"="get_policy_targets"},
 *          "policy_new_version"={"method"="post", "route_name"="policy_new_version"}
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
     * @ORM\Column(type="datetime")
     */
    private $publishedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PolicyUsers", mappedBy="policy", orphanRemoval=true)
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
            $policyUser->setPolicy($this);
        }

        return $this;
    }

    public function removePolicyUser(PolicyUsers $policyUser): self
    {
        if ($this->policyUsers->contains($policyUser)) {
            $this->policyUsers->removeElement($policyUser);
            // set the owning side to null (unless already changed)
            if ($policyUser->getPolicy() === $this) {
                $policyUser->setPolicy(null);
            }
        }

        return $this;
    }
    public function __clone()
    {
        list($major, $minor) = explode('.', $this->getVersion());
        $newVersion = sprintf("%d.%d", $major, ++$minor);
        $this->setVersion($newVersion);
    }
}
