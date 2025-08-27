<?php

namespace App\Application\Course\Handler;

use App\Application\Course\Schema\CourseFormSchema;

class GetCourseFormSchemaHandler
{
    public function handle(): CourseFormSchema
    {
        return CourseFormSchema::default();
    }
}
