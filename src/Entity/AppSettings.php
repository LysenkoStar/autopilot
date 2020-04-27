<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AppSettingsRepository")
 */
class AppSettings
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $renew_rate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $receive_notifications;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRenewRate(): ?bool
    {
        return $this->renew_rate;
    }

    public function setRenewRate(bool $renew_rate): self
    {
        $this->renew_rate = $renew_rate;

        return $this;
    }

    public function getReceiveNotifications(): ?bool
    {
        return $this->receive_notifications;
    }

    public function setReceiveNotifications(bool $receive_notifications): self
    {
        $this->receive_notifications = $receive_notifications;

        return $this;
    }
}
