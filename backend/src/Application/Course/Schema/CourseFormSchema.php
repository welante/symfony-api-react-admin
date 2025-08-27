<?php

namespace App\Application\Course\Schema;

class CourseFormSchema
{
    public function __construct(
        public array $fields
    ) {}

    public static function default(): self
    {
        return new self(
            fields: [
                ['name' => 'code', 'label' => 'Code', 'type' => 'string', 'required' => true],
                ['name' => 'active', 'label' => 'Active', 'type' => 'boolean'],
                ['name' => 'persmax', 'label' => 'Max Persons', 'type' => 'number'],
                ['name' => 'persmin', 'label' => 'Min Persons', 'type' => 'number'],
                ['name' => 'isconfirmed', 'label' => 'Confirmed', 'type' => 'boolean'],
                ['name' => 'cancelled', 'label' => 'Cancelled At', 'type' => 'datetime'],
                ['name' => 'start', 'label' => 'Start Date', 'type' => 'datetime'],
                ['name' => 'end', 'label' => 'End Date', 'type' => 'datetime'],
                ['name' => 'createdAt', 'label' => 'Created At', 'type' => 'datetime', 'readonly' => true],
                ['name' => 'updatedAt', 'label' => 'Updated At', 'type' => 'datetime', 'readonly' => true],
            ]
        );
    }
}
