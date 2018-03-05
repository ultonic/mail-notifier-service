<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\MailTemplateRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class MailTemplate
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Assert\DateTime
     */
    private $modifiedAt;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="form.blank")
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="form.blank")
     */
    private $data_type;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="form.blank")
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="form.blank")
     */
    private $body;


    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setDate(): void
    {
        $this->modifiedAt = new \DateTime();
    }

    public function getModifiedAt(): \DateTime
    {
        return $this->modifiedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    public function getDataType(): ?string
    {
        return $this->data_type;
    }

    public function setDataType(?string $data_type): void
    {
        $this->data_type = $data_type;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): void
    {
        $this->subject = $subject;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): void
    {
        $this->body = $body;
    }
}
