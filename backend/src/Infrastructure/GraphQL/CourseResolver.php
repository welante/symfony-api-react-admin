<?php

declare(strict_types=1);

namespace App\Infrastructure\GraphQL;

use App\Application\Course\Handler\GetCourseFormDataHandler;
use App\Application\Course\Handler\GetCourseListHandler;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

class CourseResolver implements ResolverInterface, AliasedInterface
{
    public function __construct(
        private GetCourseFormDataHandler $courseHandler,
        private GetCourseListHandler $coursesHandler
    ) {}

    public function resolveCourse(array $args): ?\stdClass
    {
        $id = (int) $args['id'];
        $dto = $this->courseHandler->handle($id);

        if ($dto === null) {
            return null;
        }

        $result = new \stdClass();
        $result->id = $id;
        $result->code = $dto->code;
        $result->active = $dto->active;
        $result->persmax = $dto->persmax;
        $result->persmin = $dto->persmin;
        $result->isconfirmed = $dto->isconfirmed;
        $result->start = $dto->start;
        $result->end = $dto->end;
        $result->cancelled = $dto->cancelled;
        $result->createdAt = $dto->createdAt;
        $result->updatedAt = $dto->updatedAt;

        return $result;
    }

    public function resolveCourses(array $args): array
    {
        $limit = (int) ($args['limit'] ?? 10);
        $offset = (int) ($args['offset'] ?? 0);
        $sort = (string) ($args['sort'] ?? 'id');
        $order = (string) ($args['order'] ?? 'ASC');
        $filters = isset($args['filters']) && $args['filters']
            ? json_decode($args['filters'], true)
            : [];

        $perPage = max(1, $limit);
        $page = (int) floor($offset / $perPage) + 1;

        $result = $this->coursesHandler->handle($filters, $sort, $order, $page, $perPage);

        $items = array_map(function ($dto) {
            $item = new \stdClass();
            $item->id = $dto->id;
            $item->code = $dto->code;
            $item->active = $dto->active;
            $item->persmax = $dto->persmax;
            $item->persmin = $dto->persmin;
            $item->isconfirmed = $dto->isconfirmed;
            $item->start = $dto->start;
            $item->end = $dto->end;
            $item->cancelled = $dto->cancelled;
            $item->createdAt = null;
            $item->updatedAt = null;
            return $item;
        }, $result['data']);

        $totalCount = $result['total'];
        $hasNextPage = ($offset + $limit) < $totalCount;

        return [
            'items' => $items,
            'totalCount' => $totalCount,
            'hasNextPage' => $hasNextPage,
        ];
    }

    public static function getAliases(): array
    {
        return [
            'resolveCourse' => 'CourseResolver',
            'resolveCourses' => 'CoursesResolver',
        ];
    }
}
