<?php

namespace App\Application\Course\DTO;

class CourseFormDataDTO
{
    public function __construct(
        public string $code,
        public ?bool $active,
        public ?int $persmax,
        public ?int $persmin,
        public ?bool $isconfirmed,
        public ?\DateTimeInterface $cancelled,
        public ?\DateTimeInterface $start,
        public ?\DateTimeInterface $end,
        public \DateTimeInterface $createdAt,
        public \DateTimeInterface $updatedAt
    ) {}
}
