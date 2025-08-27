<?php

namespace App\Application\Course\Handler;

use App\Application\Course\DTO\CourseListItemDTO;
use App\Domain\Course\CourseRepositoryInterface;

class GetCourseListHandler
{
    public function __construct(private CourseRepositoryInterface $repository) {}

    /**
     * @return CourseListItemDTO[]
     */
    public function handle(): array
    {
        $courses = $this->repository->findAll();

        return array_map(fn($course) =>
        new CourseListItemDTO(
            id: $course->getId(),
            code: $course->getCode(),
            active: $course->isActive(),
            persmax: $course->getPersmax(),
            persmin: $course->getPersmin(),
            isconfirmed: $course->isConfirmed(),
            start: $course->getStart(),
            end: $course->getEnd()
        ),
            $courses
        );
    }
}
