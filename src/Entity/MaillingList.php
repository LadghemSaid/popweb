<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MaillingListRepository")
 */
class MaillingList
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
    private $mail;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $contactMail;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $newsletterMail;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getContactMail(): ?bool
    {
        return $this->contactMail;
    }

    public function setContactMail(bool $contactMail): self
    {
        $this->contactMail = $contactMail;

        return $this;
    }

    public function getNewsletterMail(): ?bool
    {
        return $this->newsletterMail;
    }

    public function setNewsletterMail(?bool $newsletterMail): self
    {
        $this->newsletterMail = $newsletterMail;

        return $this;
    }
}
