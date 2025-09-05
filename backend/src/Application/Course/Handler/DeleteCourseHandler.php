<?php

namespace App\Application\Course\Handler;

use App\Domain\Course\CourseRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class DeleteCourseHandler
{
    public function __construct(
        private CourseRepositoryInterface $repository,
        private EntityManagerInterface    $em
    )
    {
    }

    public function handle(int $id): void
    {
        $course = $this->repository->find($id);
        if ($course) {
            $this->em->remove($course);
            $this->em->flush();
        }
    }
}
