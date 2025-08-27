<?php

namespace App\Infrastructure\Repository;

use App\Domain\Course\Course;
use App\Domain\Course\CourseRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineCourseRepository extends ServiceEntityRepository implements CourseRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }

    public function findById(int $id): ?Course
    {
        return parent::find($id);
    }

    public function save(Course $course): void
    {
        $em = $this->getEntityManager();
        $em->persist($course);
        $em->flush();
    }

    public function delete(Course $course): void
    {
        $em = $this->getEntityManager();
        $em->remove($course);
        $em->flush();
    }
}
