<?php

namespace App\Application\Course\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class CourseFormDataDTO
{
    public function __construct(
        #[Assert\NotBlank(message: "Code is required")]
        #[Assert\Length(max: 50, maxMessage: "Code cannot exceed {{ limit }} characters")]
        public string $code,

        public ?bool $active,

        #[Assert\PositiveOrZero(message: "Maximum participants must be 0 or higher")]
        public ?int $persmax,

        #[Assert\PositiveOrZero(message: "Minimum participants must be 0 or higher")]
        public ?int $persmin,

        public ?bool $isconfirmed,

        public ?\DateTimeInterface $cancelled,

        // Start date is optional, only validated if both start and end are provided
        public ?\DateTimeInterface $start,

        // End date is optional, only validated if both start and end are provided
        public ?\DateTimeInterface $end,

        public \DateTimeInterface $createdAt,
        public \DateTimeInterface $updatedAt
    ) {}

    /**
     * Custom validation rules that depend on multiple fields
     */
    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context): void
    {
        // Maximum participants must never be less than minimum participants
        if ($this->persmax !== null && $this->persmin !== null && $this->persmax < $this->persmin) {
            $context->buildViolation('Maximum participants cannot be less than minimum participants')
                ->atPath('persmax')
                ->addViolation();
        }

        // If both start and end are provided, start must be earlier than end
        if ($this->start !== null && $this->end !== null && $this->end < $this->start) {
            $context->buildViolation('End date must be later than start date')
                ->atPath('end')
                ->addViolation();
        }
    }
}
