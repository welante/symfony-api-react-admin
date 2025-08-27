<?php

namespace App\DataFixtures;

use App\Domain\Course\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CourseFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $courses = [
            [
                'code' => 'COURSE-001',
                'active' => true,
                'persmax' => 30,
                'persmin' => 5,
                'isconfirmed' => true,
                'cancelled' => null,
                'start' => new \DateTimeImmutable('+1 week'),
                'end' => new \DateTimeImmutable('+2 weeks'),
            ],
            [
                'code' => 'COURSE-002',
                'active' => false,
                'persmax' => 25,
                'persmin' => 10,
                'isconfirmed' => false,
                'cancelled' => new \DateTimeImmutable('-3 days'),
                'start' => new \DateTimeImmutable('-2 weeks'),
                'end' => new \DateTimeImmutable('-1 week'),
            ],
            [
                'code' => 'COURSE-003',
                'active' => true,
                'persmax' => 100,
                'persmin' => 50,
                'isconfirmed' => true,
                'cancelled' => null,
                'start' => new \DateTimeImmutable('2025-09-01'),
                'end' => new \DateTimeImmutable('2025-09-30'),
            ],
            [
                'code' => 'COURSE-004',
                'active' => true,
                'persmax' => 40,
                'persmin' => 15,
                'isconfirmed' => false,
                'cancelled' => null,
                'start' => new \DateTimeImmutable('+3 days'),
                'end' => new \DateTimeImmutable('+20 days'),
            ],
            [
                'code' => 'COURSE-005',
                'active' => false,
                'persmax' => 60,
                'persmin' => 20,
                'isconfirmed' => false,
                'cancelled' => new \DateTimeImmutable('-10 days'),
                'start' => new \DateTimeImmutable('-30 days'),
                'end' => new \DateTimeImmutable('-15 days'),
            ],
            [
                'code' => 'COURSE-006',
                'active' => true,
                'persmax' => 15,
                'persmin' => 5,
                'isconfirmed' => true,
                'cancelled' => null,
                'start' => new \DateTimeImmutable('+5 days'),
                'end' => new \DateTimeImmutable('+12 days'),
            ],
            [
                'code' => 'COURSE-007',
                'active' => true,
                'persmax' => 200,
                'persmin' => 100,
                'isconfirmed' => true,
                'cancelled' => null,
                'start' => new \DateTimeImmutable('2025-10-01'),
                'end' => new \DateTimeImmutable('2025-10-31'),
            ],
            [
                'code' => 'COURSE-008',
                'active' => false,
                'persmax' => 10,
                'persmin' => 2,
                'isconfirmed' => false,
                'cancelled' => new \DateTimeImmutable('-1 month'),
                'start' => new \DateTimeImmutable('-2 months'),
                'end' => new \DateTimeImmutable('-1 month'),
            ],
            [
                'code' => 'COURSE-009',
                'active' => true,
                'persmax' => 80,
                'persmin' => 20,
                'isconfirmed' => true,
                'cancelled' => null,
                'start' => new \DateTimeImmutable('+2 months'),
                'end' => new \DateTimeImmutable('+3 months'),
            ],
            [
                'code' => 'COURSE-010',
                'active' => true,
                'persmax' => 12,
                'persmin' => 3,
                'isconfirmed' => false,
                'cancelled' => null,
                'start' => new \DateTimeImmutable('+1 day'),
                'end' => new \DateTimeImmutable('+7 days'),
            ],
            [
                'code' => 'COURSE-011',
                'active' => false,
                'persmax' => 45,
                'persmin' => 10,
                'isconfirmed' => false,
                'cancelled' => new \DateTimeImmutable('-5 days'),
                'start' => new \DateTimeImmutable('-20 days'),
                'end' => new \DateTimeImmutable('-10 days'),
            ],
            [
                'code' => 'COURSE-012',
                'active' => true,
                'persmax' => 90,
                'persmin' => 30,
                'isconfirmed' => true,
                'cancelled' => null,
                'start' => new \DateTimeImmutable('2025-12-01'),
                'end' => new \DateTimeImmutable('2025-12-31'),
            ],
        ];

        foreach ($courses as $data) {
            $course = new Course($data['code']);
            $course->setActive($data['active']);
            $course->setPersmax($data['persmax']);
            $course->setPersmin($data['persmin']);
            $course->setConfirmed($data['isconfirmed']);
            $course->setCancelled($data['cancelled']);
            $course->setStart($data['start']);
            $course->setEnd($data['end']);

            $manager->persist($course);
        }

        $manager->flush();
    }
}
