<?php

namespace App\Application\Course\Handler;

use App\Domain\Course\Course;
use App\Domain\Course\CourseRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class CreateCourseHandler
{
    public function __construct(
        private CourseRepositoryInterface $repository,
        private EntityManagerInterface    $em
    )
    {
    }

    public function handle(array $data): Course
    {
        $course = new Course($data['code']);
        $course->setActive($data['active'] ?? null);
        $course->setPersmax($data['persmax'] ?? null);
        $course->setPersmin($data['persmin'] ?? null);
        $course->setConfirmed($data['isconfirmed'] ?? null);
        $course->setCancelled(isset($data['cancelled']) ? new \DateTimeImmutable($data['cancelled']) : null);
        $course->setStart(isset($data['start']) ? new \DateTimeImmutable($data['start']) : null);
        $course->setEnd(isset($data['end']) ? new \DateTimeImmutable($data['end']) : null);

        $this->em->persist($course);
        $this->em->flush();

        return $course;
    }
}
