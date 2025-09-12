<?php

namespace App\Application\Menu\Handler;

class GetMenuSchemaHandler
{
    public function handle(): array
    {
        return [
            [
                'name' => 'clients',
                'label' => 'Clients',
                'icon' => 'Group',
                'type' => 'resource',
                'resource' => 'clients',
            ],
            [
                'name' => 'courses',
                'label' => 'Courses',
                'icon' => 'Book',
                'type' => 'parent',
                'children' => [
                    [
                        'name' => 'course-list',
                        'label' => 'List',
                        'icon' => 'CalendarToday',
                        'type' => 'resource',
                        'resource' => 'courses',
                        'tabs' => [
                            ['name' => 'all', 'label' => 'All', 'filters' => []],
                            ['name' => 'active', 'label' => 'Active', 'filters' => ['active' => true]],
                            ['name' => 'cancelled', 'label' => 'Cancelled', 'filters' => ['cancelled' => true]],
                        ],
                    ],
                    [
                        'name' => 'speakers',
                        'label' => 'Speakers',
                        'icon' => 'Person',
                        'type' => 'resource',
                        'resource' => 'speakers',
                    ],
                ],
            ],
        ];
    }
}
