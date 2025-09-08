<?php

namespace App\Application\Course\Handler;

use App\Application\Common\AbstractHandler;
use App\Application\Course\DTO\CourseFormDataDTO;
use App\Domain\Course\Course;
use App\Domain\Course\CourseRepositoryInterface;
use DateMalformedStringException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateCourseHandler extends AbstractHandler
{
    private CourseRepositoryInterface $repository;
    private EntityManagerInterface $em;

    public function __construct(
        CourseRepositoryInterface $repository,
        EntityManagerInterface    $em,
        ValidatorInterface        $validator
    )
    {
        $this->repository = $repository;
        $this->em = $em;

        parent::__construct($validator);
    }

    /**
     * @throws DateMalformedStringException
     */
    public function handle(array $data): Course
    {
        $dto = new CourseFormDataDTO(
            $data['code'] ?? '',
            $data['active'] ?? null,
            $data['persmax'] ?? null,
            $data['persmin'] ?? null,
            $data['isconfirmed'] ?? null,
            isset($data['cancelled']) ? new \DateTimeImmutable($data['cancelled']) : null,
            isset($data['start']) ? new \DateTimeImmutable($data['start']) : null,
            isset($data['end']) ? new \DateTimeImmutable($data['end']) : null,
            new \DateTimeImmutable(),
            new \DateTimeImmutable()
        );

        $this->validateDto($dto);

        $course = new Course($dto->code);
        $course->setActive($dto->active);
        $course->setPersmax($dto->persmax);
        $course->setPersmin($dto->persmin);
        $course->setConfirmed($dto->isconfirmed);
        $course->setCancelled($dto->cancelled);
        $course->setStart($dto->start);
        $course->setEnd($dto->end);

        $this->em->persist($course);
        $this->em->flush();

        return $course;
    }
}
