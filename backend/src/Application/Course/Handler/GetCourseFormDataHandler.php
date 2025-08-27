<?php

namespace App\Application\Course\Handler;

use App\Application\Course\DTO\CourseFormDataDTO;
use App\Domain\Course\CourseRepositoryInterface;

class GetCourseFormDataHandler
{
    public function __construct(private CourseRepositoryInterface $repository) {}

    public function handle(int $id): ?CourseFormDataDTO
    {
        $course = $this->repository->findById($id);

        if (!$course) {
            return null;
        }

        return new CourseFormDataDTO(
            code: $course->getCode(),
            active: $course->isActive(),
            persmax: $course->getPersmax(),
            persmin: $course->getPersmin(),
            isconfirmed: $course->isConfirmed(),
            cancelled: $course->getCancelled(),
            start: $course->getStart(),
            end: $course->getEnd(),
            createdAt: $course->getCreatedAt(),
            updatedAt: $course->getUpdatedAt()
        );
    }
}
