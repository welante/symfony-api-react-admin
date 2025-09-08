<?php

namespace App\Application\Course\Handler;

use App\Application\Common\AbstractHandler;
use App\Application\Course\DTO\CourseFormDataDTO;
use App\Domain\Course\CourseRepositoryInterface;
use DateMalformedStringException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateCourseHandler extends AbstractHandler
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
    public function handle(int $id, array $data)
    {
        $course = $this->repository->find($id);
        if (!$course) {
            throw new \RuntimeException("Course not found");
        }

        $dto = new CourseFormDataDTO(
            $data['code'] ?? $course->getCode(),
            $data['active'] ?? $course->isActive(),
            $data['persmax'] ?? $course->getPersmax(),
            $data['persmin'] ?? $course->getPersmin(),
            $data['isconfirmed'] ?? $course->isConfirmed(),
            isset($data['cancelled']) ? new \DateTimeImmutable($data['cancelled']) : $course->getCancelled(),
            isset($data['start']) ? new \DateTimeImmutable($data['start']) : $course->getStart(),
            isset($data['end']) ? new \DateTimeImmutable($data['end']) : $course->getEnd(),
            $course->getCreatedAt(),
            new \DateTimeImmutable()
        );

        $this->validateDto($dto);

        $course->setCode($dto->code);
        $course->setActive($dto->active);
        $course->setPersmax($dto->persmax);
        $course->setPersmin($dto->persmin);
        $course->setConfirmed($dto->isconfirmed);
        $course->setCancelled($dto->cancelled);
        $course->setStart($dto->start);
        $course->setEnd($dto->end);

        $this->em->flush();

        return $course;
    }
}
