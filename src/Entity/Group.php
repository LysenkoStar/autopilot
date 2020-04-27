<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GroupRepository")
 * @ORM\Table(name="`group`")
 */
class Group
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="user", referencedColumnName="vk_id")
     */
    private $user;

    /**
     * @ORM\Column(name="image", type="string")
     */
    private $image;

    /**
     * @ORM\Column(name="vk_id", type="integer")
     */
    private $vk_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $settings;

    /**
     * @ORM\Column(name="`resources`", type="string", length=255, nullable=true)
     */
    private $resources;

    /**
     * @ORM\Column(name="`actions`", type="string", length=255, nullable=true)
     */
    private $actions;

    /**
     * @ORM\Column(name="`name`", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(name="`type`", type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(name="`closed`", type="boolean")
     */
    private $closed;

    /**
     * @ORM\Column(type="integer")
     */
    private $members_count;

    /**
     * @ORM\Column(name="connected", type="boolean", nullable=true, options={ "default":0 } )
     */
    private $connected;

    /**
     * @ORM\Column(name="access_token", type="string", nullable=true)
     */
    private $accessToken;

    /**
     * @var DateTime
     * @ORM\Column(name="date_added", type="datetime", nullable=true, unique=false)
     */
    private $dateAdded;

    public function __construct()
    {
        $this->setDateAdded(new DateTime());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getVkId(): ?int
    {
        return $this->vk_id;
    }

    public function setVkId(int $vk_id): self
    {
        $this->vk_id = $vk_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }

    public function getSettings(): ?string
    {
        return $this->settings;
    }

    public function setSettings(string $settings): self
    {
        $this->settings = $settings;

        return $this;
    }

    public function getResources(): ?string
    {
        return $this->resources;
    }

    public function setResources(string $resources): self
    {
        $this->resources = $resources;

        return $this;
    }

    public function getActions(): ?string
    {
        return $this->actions;
    }

    public function setActions(string $actions): self
    {
        $this->actions = $actions;

        return $this;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getClosed(): ?bool
    {
        return $this->closed;
    }

    public function setClosed(bool $closed): self
    {
        $this->closed = $closed;

        return $this;
    }

    public function getMembersCount(): ?int
    {
        return $this->members_count;
    }

    public function setMembersCount(int $members_count): self
    {
        $this->members_count = $members_count;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getConnected()
    {
        return $this->connected;
    }

    /**
     * @param mixed $connected
     */
    public function setConnected($connected): void
    {
        $this->connected = $connected;
    }

    /**
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param mixed $accessToken
     */
    public function setAccessToken($accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return DateTime
     */
    public function getDateAdded(): DateTime
    {
        return $this->dateAdded;
    }

    /**
     * @param DateTime $dateAdded
     */
    public function setDateAdded(DateTime $dateAdded): void
    {
        $this->dateAdded = $dateAdded;
    }

}
