<?php

namespace App\Application\Course\Handler;

use App\Application\Course\DTO\CourseListItemDTO;
use App\Domain\Course\CourseRepositoryInterface;

class GetCourseListHandler
{
    public function __construct(private CourseRepositoryInterface $repository) {}

    /**
     * @return array{data: CourseListItemDTO[], total: int}
     */
    public function handle(
        array  $filters = [],
        string $sort = 'id',
        string $order = 'ASC',
        int    $page = 1,
        int    $perPage = 10
    ): array
    {
        $total = $this->repository->countByFilters($filters);
        $courses = $this->repository->findByFilters($filters, $sort, $order, $page, $perPage);

        return [
            'data' => array_map(fn($course) => new CourseListItemDTO(
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
            ),
            'total' => $total,
        ];
    }
}
