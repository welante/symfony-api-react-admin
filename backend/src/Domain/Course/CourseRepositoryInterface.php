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
}
