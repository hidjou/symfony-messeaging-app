<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 * @ORM\Table(name="messages")
 */
class Message
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=140)
     * @Assert\NotBlank(
     *     message = "Cannot send an empty text"
     * )
     * * @Assert\Length(
     *     max = 140,
     *     maxMessage = "Cannot be more than 140 characters"
     * )
     */
    private $text;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $user_id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(
     *     message = "Recipient's number must not be empty"
     * )
     * @Assert\Length(
     *     min = 5,
     *     max = 50,
     *     minMessage = "The shortest phone number contains at least 5 digits (Solomon Islands)",
     *     maxMessage = "The longest phone number contains 50 digits max"
     * )
     */
    private $recipient;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(?int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getRecipient(): ?string
    {
        return $this->recipient;
    }

    public function setRecipient(string $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }
}
