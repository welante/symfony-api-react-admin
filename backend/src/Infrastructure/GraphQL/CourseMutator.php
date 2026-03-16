<?php

declare(strict_types=1);

namespace App\Infrastructure\GraphQL;

use App\Application\Course\Handler\CreateCourseHandler;
use App\Application\Course\Handler\DeleteCourseHandler;
use App\Application\Course\Handler\GetCourseFormDataHandler;
use App\Application\Course\Handler\UpdateCourseHandler;
use App\Domain\Course\Course;
use GraphQL\Error\Error as GraphQLError;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class CourseMutator implements MutationInterface, AliasedInterface
{
    public function __construct(
        private CreateCourseHandler $createHandler,
        private UpdateCourseHandler $updateHandler,
        private DeleteCourseHandler $deleteHandler,
        private GetCourseFormDataHandler $getHandler
    ) {}

    public function createCourse(array $args): object
    {
        // AbstractProxyResolver passes args as [0 => ArgumentObject]
        $realArgs = $args[0];
        $input = $realArgs['input'];
        $data = $input instanceof Argument ? $input->getArrayCopy() : (array) $input;

        try {
            $course = $this->createHandler->handle($data);
        } catch (ValidationFailedException $e) {
            $fieldErrors = [];
            foreach ($e->getViolations() as $violation) {
                $fieldErrors[$violation->getPropertyPath()] = (string) $violation->getMessage();
            }
            throw new GraphQLError(
                'Validation failed',
                null, null, [], null, null,
                ['category' => 'validation', 'errors' => $fieldErrors]
            );
        }

        return $this->entityToStdClass($course);
    }

    public function updateCourse(array $args): object
    {
        $realArgs = $args[0];
        $id = (int) $realArgs['id'];
        $input = $realArgs['input'];
        $data = $input instanceof Argument ? $input->getArrayCopy() : (array) $input;

        try {
            $course = $this->updateHandler->handle($id, $data);
        } catch (ValidationFailedException $e) {
            $fieldErrors = [];
            foreach ($e->getViolations() as $violation) {
                $fieldErrors[$violation->getPropertyPath()] = (string) $violation->getMessage();
            }
            throw new GraphQLError(
                'Validation failed',
                null, null, [], null, null,
                ['category' => 'validation', 'errors' => $fieldErrors]
            );
        } catch (\RuntimeException $e) {
            throw new GraphQLError(
                'Course not found',
                null, null, [], null, null,
                ['category' => 'not_found']
            );
        }

        return $this->entityToStdClass($course);
    }

    public function deleteCourse(array $args): bool
    {
        $realArgs = $args[0];
        $id = (int) $realArgs['id'];
        $existing = $this->getHandler->handle($id);
        if ($existing === null) {
            throw new GraphQLError(
                'Course not found',
                null, null, [], null, null,
                ['category' => 'not_found']
            );
        }
        $this->deleteHandler->handle($id);
        return true;
    }

    private function entityToStdClass(Course $course): object
    {
        $obj = new \stdClass();
        $obj->id = $course->getId();
        $obj->code = $course->getCode();
        $obj->active = $course->isActive();
        $obj->persmax = $course->getPersmax();
        $obj->persmin = $course->getPersmin();
        $obj->isconfirmed = $course->isConfirmed();
        $obj->start = $course->getStart();
        $obj->end = $course->getEnd();
        $obj->cancelled = $course->getCancelled();
        $obj->createdAt = $course->getCreatedAt();
        $obj->updatedAt = $course->getUpdatedAt();
        return $obj;
    }

    public static function getAliases(): array
    {
        return [
            'createCourse' => 'createCourse',
            'updateCourse' => 'updateCourse',
            'deleteCourse' => 'deleteCourse',
        ];
    }
}
