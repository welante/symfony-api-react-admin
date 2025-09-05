<?php

namespace App\Application\Course\Schema;

class CourseListSchema
{
    public function __construct(
        public array $columns,
        public array $filters,
        public array $defaultSort
    ) {}

    public static function default(): self
    {
        return new self(
            columns: [
                ['name' => 'id', 'label' => 'ID', 'type' => 'number'],
                ['name' => 'code', 'label' => 'Code', 'type' => 'string'],
                ['name' => 'active', 'label' => 'Active', 'type' => 'boolean'],
                ['name' => 'persmax', 'label' => 'Max Persons', 'type' => 'number'],
                ['name' => 'persmin', 'label' => 'Min Persons', 'type' => 'number'],
                ['name' => 'isconfirmed', 'label' => 'Confirmed', 'type' => 'boolean'],
                ['name' => 'start', 'label' => 'Start Date', 'type' => 'datetime'],
                ['name' => 'end', 'label' => 'End Date', 'type' => 'datetime'],
            ],
            filters: [
                ['name' => 'code', 'type' => 'string'],
                ['name' => 'active', 'type' => 'boolean'],
                ['name' => 'isconfirmed', 'type' => 'boolean'],
                ['name' => 'persmax', 'label' => 'Max Persons', 'type' => 'number'],
                ['name' => 'persmin', 'label' => 'Min Persons', 'type' => 'number'],
                ['name' => 'start', 'label' => 'Start Date', 'type' => 'datetime'],
                ['name' => 'end', 'label' => 'End Date', 'type' => 'datetime'],
            ],
            defaultSort: ['field' => 'id', 'order' => 'DESC']
        );
    }
}
