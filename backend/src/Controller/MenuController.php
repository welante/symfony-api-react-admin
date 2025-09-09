<?php

namespace App\Controller;

use App\Application\Menu\Handler\GetMenuSchemaHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    #[Route('/api/metadata/menu', name: 'api_metadata_menu', methods: ['GET'])]
    public function menuSchema(GetMenuSchemaHandler $handler): JsonResponse
    {
        $data = $handler->handle();
        return $this->json($data);
    }
}
