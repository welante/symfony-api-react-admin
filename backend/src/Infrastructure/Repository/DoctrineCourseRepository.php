<?php

namespace App\Infrastructure\Repository;

use App\Domain\Course\Course;
use App\Domain\Course\CourseRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use PDO;

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

    public function findByFilters(array $filters, string $sort, string $order, int $page, int $perPage): array
    {
        $qb = $this->createQueryBuilder('c');

        $this->applyFilters($qb, $filters);

        $qb->orderBy('c.' . $sort, $order)
           ->setFirstResult(($page - 1) * $perPage)
           ->setMaxResults($perPage);

        return iterator_to_array(new Paginator($qb));
    }

    public function countByFilters(array $filters): int
    {
        $qb = $this->createQueryBuilder('c')
                   ->select('COUNT(c.id)');

        $this->applyFilters($qb, $filters);

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * Apply dynamic filters to a QueryBuilder based on Doctrine metadata.
     */
    private function applyFilters(QueryBuilder $qb, array $filters): void
    {
        $metadata = $this->getEntityManager()->getClassMetadata(Course::class);

        foreach ($filters as $field => $value) {
            if ($value === null || $value === '') {
                continue;
            }

            if (!in_array($field, $metadata->getFieldNames(), true)) {
                continue; // skip invalid fields
            }

            $param = ':' . $field;
            $type  = $metadata->getTypeOfField($field);

            switch ($type) {
                case 'string':
                    $qb->andWhere("c.$field LIKE $param")
                        ->setParameter($field, '%' . $value . '%');
                    break;

                case 'boolean':
                    // normalize string values coming from query (?active=true)
                    if (is_string($value)) {
                        $value = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
                    }
                    $qb->andWhere("c.$field = $param")
                        ->setParameter($field, $value, PDO::PARAM_BOOL);
                    break;

                case 'integer':
                case 'smallint':
                case 'bigint':
                    $qb->andWhere("c.$field = $param")
                        ->setParameter($field, (int) $value);
                    break;

                case 'datetime':
                case 'datetimetz':
                case 'date':
                    $qb->andWhere("c.$field = $param")
                        ->setParameter($field, new \DateTime($value));
                    break;

                default:
                    $qb->andWhere("c.$field = $param")
                        ->setParameter($field, $value);
                    break;
            }
        }
    }
}
