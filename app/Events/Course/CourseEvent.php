<?php
namespace Vanguard\Events\Course;

use Vanguard\Models\Course;

abstract class CourseEvent
{
    /**
     * @var Course
     */
    protected $course;

    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    /**
     * @return Course
     */
    public function getCourse()
    {
        return $this->course;
    }
}