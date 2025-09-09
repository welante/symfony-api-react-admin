<?php

namespace App\Application\Menu\Handler;

class GetMenuSchemaHandler
{
    public function handle(): array
    {
        return [
            [
                'name' => 'courses',
                'label' => 'Courses',
                'icon' => 'Book',
            ],
            [
                'name' => 'users',
                'label' => 'Users',
                'icon' => 'User',
            ],
        ];
    }
}
