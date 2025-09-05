<?php

namespace App\Application\Course\Handler;

use App\Domain\Course\CourseRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class UpdateCourseHandler
{
    public function __construct(
        private CourseRepositoryInterface $repository,
        private EntityManagerInterface    $em
    )
    {
    }

    public function handle(int $id, array $data)
    {
        $course = $this->repository->find($id);
        if (!$course) {
            throw new \RuntimeException("Course not found");
        }

        $course->setCode($data['code'] ?? $course->getCode());
        $course->setActive($data['active'] ?? $course->isActive());
        $course->setPersmax($data['persmax'] ?? $course->getPersmax());
        $course->setPersmin($data['persmin'] ?? $course->getPersmin());
        $course->setConfirmed($data['isconfirmed'] ?? $course->isConfirmed());
        $course->setCancelled(isset($data['cancelled']) ? new \DateTimeImmutable($data['cancelled']) : $course->getCancelled());
        $course->setStart(isset($data['start']) ? new \DateTimeImmutable($data['start']) : $course->getStart());
        $course->setEnd(isset($data['end']) ? new \DateTimeImmutable($data['end']) : $course->getEnd());

        $this->em->flush();

        return $course;
    }
}
