<?php

namespace App\Domain\Course;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Common\TimestampableTrait;

#[ORM\Entity(repositoryClass: "App\Infrastructure\Repository\DoctrineCourseRepository")]
#[ORM\Table(name: "courses")]
#[ORM\HasLifecycleCallbacks]
class Course
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "bigint")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 50, nullable: false)]
    private string $code;

    #[ORM\Column(type: "boolean", nullable: true)]
    private ?bool $active = null;

    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $persmax = null;

    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $persmin = null;

    #[ORM\Column(type: "boolean", nullable: true)]
    private ?bool $isconfirmed = null;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeInterface $cancelled = null;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeInterface $start = null;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeInterface $end = null;

    public function __construct(string $code)
    {
        $this->code = $code;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): void
    {
        $this->active = $active;
    }

    public function getPersmax(): ?int
    {
        return $this->persmax;
    }

    public function setPersmax(?int $persmax): void
    {
        $this->persmax = $persmax;
    }

    public function getPersmin(): ?int
    {
        return $this->persmin;
    }

    public function setPersmin(?int $persmin): void
    {
        $this->persmin = $persmin;
    }

    public function isConfirmed(): ?bool
    {
        return $this->isconfirmed;
    }

    public function setConfirmed(?bool $isconfirmed): void
    {
        $this->isconfirmed = $isconfirmed;
    }

    public function getCancelled(): ?\DateTimeInterface
    {
        return $this->cancelled;
    }

    public function setCancelled(?\DateTimeInterface $cancelled): void
    {
        $this->cancelled = $cancelled;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(?\DateTimeInterface $start): void
    {
        $this->start = $start;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(?\DateTimeInterface $end): void
    {
        $this->end = $end;
    }
}
