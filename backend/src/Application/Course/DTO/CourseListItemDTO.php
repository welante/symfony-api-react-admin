<?php

namespace App\Application\Course\DTO;

class CourseListItemDTO
{
    public function __construct(
        public int $id,
        public string $code,
        public ?bool $active,
        public ?int $persmax,
        public ?int $persmin,
        public ?bool $isconfirmed,
        public ?\DateTimeInterface $start,
        public ?\DateTimeInterface $end,
        public ?\DateTimeInterface $cancelled
    ) {}
}
