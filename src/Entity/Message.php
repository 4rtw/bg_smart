<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 *
 * @ApiResource(
 *     normalizationContext={"groups"={"create:message"}},
 *     collectionOperations={
 *          "post"={
 *              "controller" = App\Controller\Api\MessageController::class,
 *              "denormalization_context" = {"groups"={"create:message"}}
 *          }
 *     },
 *     itemOperations={
 *          "get"={
 *             "controller"="NotFoundAction::class",
 *              "openapi_context"={"summary"="hidden"},
 *             "read"=false,
 *             "output"=false
 *         }
 *      }
 * )
 *
 *
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"create:message"})
     */
    private $sender;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"create:message"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"create:message"})
     */
    private $subject;

    /**
     * @ORM\Column(type="text")
     * @Groups({"create:message"})
     */
    private $content;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSender(): ?string
    {
        return $this->sender;
    }

    public function setSender(string $sender): self
    {
        $this->sender = $sender;

        return $this;
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

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
