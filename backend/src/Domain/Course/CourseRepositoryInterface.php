<?php

namespace App\Domain\Course;

interface CourseRepositoryInterface
{
    /**
     * @return Course[]
     */
    public function findAll(): array;

    public function findById(int $id): ?Course;

    public function save(Course $course): void;

    public function delete(Course $course): void;

    /**
     * @param array<string, mixed> $filters Example: ['active' => true, 'code' => 'COURSE-001']
     * @param string $sort Field to order by (e.g. "id")
     * @param string $order ASC or DESC
     * @param int $page Current page (1-based)
     * @param int $perPage Results per page
     *
     * @return Course[]
     */
    public function findByFilters(array $filters, string $sort, string $order, int $page, int $perPage): array;

    public function countByFilters(array $filters): int;
}
