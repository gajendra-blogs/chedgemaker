<?php

namespace Vanguard\Events\Course;

use Vanguard\Models\Course;

class Deleted
{
    /**
     * @var Course
     */
    protected $deletedCourse;

    public function __construct(Course $deletedCourse)
    {
        $this->deletedCourse = $deletedCourse;
    }

    /**
     * @return Course
     */
    public function getDeletedCourse()
    {
        return $this->deletedCourse;
    }
}
