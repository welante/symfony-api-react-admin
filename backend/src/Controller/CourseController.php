<?php

namespace App\Controller;

use App\Application\Course\Handler\GetCourseListHandler;
use App\Application\Course\Handler\GetCourseListSchemaHandler;
use App\Application\Course\Handler\GetCourseFormSchemaHandler;
use App\Application\Course\Handler\GetCourseFormDataHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CourseController extends AbstractController
{
    #[Route('/api/courses', name: 'api_courses_list', methods: ['GET'])]
    public function list(GetCourseListHandler $handler): JsonResponse
    {
        $data = $handler->handle();
        return $this->json($data);
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
}
