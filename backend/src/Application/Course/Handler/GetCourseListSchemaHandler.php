<?php

namespace App\Application\Course\Handler;

use App\Application\Course\Schema\CourseListSchema;

class GetCourseListSchemaHandler
{
    public function handle(): CourseListSchema
    {
        return CourseListSchema::default();
    }
}
