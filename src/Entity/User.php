<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="integer", nullable=false, unique=false)
     */
    private $vk_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $surname;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_closed;

    /**
     * @ORM\Column(type="boolean")
     */
    private $can_access_closed;

    /**
     * @ORM\Column(type="smallint")
     */
    private $sex;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bdate;

    /**
     * @ORM\Column(type="integer")
     */
    private $city_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="integer")
     */
    private $country_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo_min;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo_max;

    /**
     * @ORM\Column(type="boolean")
     */
    private $has_photo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $has_mobile;

    /**
     * @ORM\Column(type="boolean")
     */
    private $verified;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $access_token;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\AppSettings", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="app_settings", referencedColumnName="id")
     */
    private $appSettings;

    public function __construct(int $vk_id)
    {
        $this->vk_id = $vk_id;
        $this->created_at = new \DateTime();
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getSex(): ?int
    {
        return $this->sex;
    }

    public function setSex(int $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getIsClosed(): ?bool
    {
        return $this->is_closed;
    }

    public function setIsClosed(bool $is_closed): self
    {
        $this->is_closed = $is_closed;

        return $this;
    }

    public function getBdate(): ?string
    {
        return $this->bdate;
    }

    public function setBdate(string $bdate): self
    {
        $this->bdate = $bdate;

        return $this;
    }

    public function getCountryId(): ?int
    {
        return $this->country_id;
    }

    public function setCountryId(int $country_id): self
    {
        $this->country_id = $country_id;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getVerified(): ?bool
    {
        return $this->verified;
    }

    public function setVerified(bool $verified): self
    {
        $this->verified = $verified;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @return mixed
     */
    public function getVkId()
    {
        return $this->vk_id;
    }

    /**
     * @param mixed $vk_id
     */
    public function setVkId($vk_id): void
    {
        $this->vk_id = $vk_id;
    }

    /**
     * @return mixed
     */
    public function getCanAccessClosed()
    {
        return $this->can_access_closed;
    }

    /**
     * @param mixed $can_access_closed
     */
    public function setCanAccessClosed($can_access_closed): void
    {
        $this->can_access_closed = $can_access_closed;
    }

    /**
     * @return mixed
     */
    public function getCityId()
    {
        return $this->city_id;
    }

    /**
     * @param mixed $city_id
     */
    public function setCityId($city_id): void
    {
        $this->city_id = $city_id;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city): void
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getPhotoMin()
    {
        return $this->photo_min;
    }

    /**
     * @param mixed $photo_min
     */
    public function setPhotoMin($photo_min): void
    {
        $this->photo_min = $photo_min;
    }

    /**
     * @return mixed
     */
    public function getPhotoMax()
    {
        return $this->photo_max;
    }

    /**
     * @param mixed $photo_max
     */
    public function setPhotoMax($photo_max): void
    {
        $this->photo_max = $photo_max;
    }

    /**
     * @return mixed
     */
    public function getHasPhoto()
    {
        return $this->has_photo;
    }

    /**
     * @param mixed $has_photo
     */
    public function setHasPhoto($has_photo): void
    {
        $this->has_photo = $has_photo;
    }

    /**
     * @return mixed
     */
    public function getHasMobile()
    {
        return $this->has_mobile;
    }

    /**
     * @param mixed $has_mobile
     */
    public function setHasMobile($has_mobile): void
    {
        $this->has_mobile = $has_mobile;
    }

    public function getAppSettings(): ?AppSettings
    {
        return $this->appSettings;
    }

    /**
     * @param AppSettings $appSettings
     */
    public function setAppSettings(AppSettings $appSettings)
    {
        $this->appSettings = $appSettings;
    }

    /**
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * @param mixed $access_token
     */
    public function setAccessToken($access_token): void
    {
        $this->access_token = $access_token;
    }
}
