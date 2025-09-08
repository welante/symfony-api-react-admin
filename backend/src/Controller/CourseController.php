<?php

namespace App\Controller;

use App\Application\Course\Handler\CreateCourseHandler;
use App\Application\Course\Handler\DeleteCourseHandler;
use App\Application\Course\Handler\GetCourseListHandler;
use App\Application\Course\Handler\GetCourseListSchemaHandler;
use App\Application\Course\Handler\GetCourseFormSchemaHandler;
use App\Application\Course\Handler\GetCourseFormDataHandler;
use App\Application\Course\Handler\UpdateCourseHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class CourseController extends AbstractController
{
    #[Route('/api/courses', name: 'api_courses_list', methods: ['GET'])]
    public function list(Request $request, GetCourseListHandler $handler): JsonResponse
    {
        $page     = max(1, (int) $request->query->get('page', 1));
        $perPage  = (int) $request->query->get('perPage', 10);
        $sort     = $request->query->get('sort', 'id');
        $order    = $request->query->get('order', 'ASC');
        // TODO Improve filters handle
        $filters = $request->query->all();
        unset($filters['page'], $filters['perPage'], $filters['sort'], $filters['order']);

        $result = $handler->handle($filters, $sort, $order, $page, $perPage);
        return $this->json($result);
    }

    #[Route('/api/metadata/courses/list', name: 'api_courses_list_schema', methods: ['GET'])]
    public function listSchema(GetCourseListSchemaHandler $handler): JsonResponse
    {
        $data = $handler->handle();
        return $this->json($data);
    }

    #[Route('/api/metadata/courses/form', name: 'api_courses_form_schema', methods: ['GET'])]
    public function formSchema(GetCourseFormSchemaHandler $handler): JsonResponse
    {
        $data = $handler->handle();
        return $this->json($data);
    }

    #[Route('/api/courses/{id}', name: 'api_course_data', methods: ['GET'])]
    public function formData(int $id, GetCourseFormDataHandler $handler): JsonResponse
    {
        $data = $handler->handle($id);
        return $this->json($data);
    }

    #[Route('/api/courses', name: 'api_course_create', methods: ['POST'])]
    public function create(Request $request, CreateCourseHandler $handler): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        try {
            $course = $handler->handle($data);
            return $this->json($course, 201);
        } catch (ValidationFailedException $e) {
            $errors = [];
            foreach ($e->getViolations() as $violation) {
                $errors[$violation->getPropertyPath()] = $violation->getMessage();
            }
            return $this->json(['errors' => $errors], 400);
        }
    }

    #[Route('/api/courses/{id}', name: 'api_course_update', methods: ['PUT'])]
    public function update(int $id, Request $request, UpdateCourseHandler $handler): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        try {
            $course = $handler->handle($id, $data);
            return $this->json($course);
        } catch (ValidationFailedException $e) {
            $errors = [];
            foreach ($e->getViolations() as $violation) {
                $errors[$violation->getPropertyPath()] = $violation->getMessage();
            }
            return $this->json(['errors' => $errors], 400);
        }
    }

    #[Route('/api/courses/{id}', name: 'api_course_delete', methods: ['DELETE'])]
    public function delete(int $id, DeleteCourseHandler $handler): JsonResponse
    {
        $handler->handle($id);
        return $this->json(['status' => 'ok']);
    }
}
