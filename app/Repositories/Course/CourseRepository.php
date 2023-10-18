<?php

namespace Vanguard\Repositories\Course;
use Vanguard\Models\Course;

interface CourseRepository
{

     /**
     * Get all courses.
     *
     * @return mixed
     */
    public function all();

     /**
     * Paginate Courses.
     *
     * @param $perPage
     * @param null $search
     * @param null $status
     * @return mixed
     */
    public function paginate($perPage, $search = null, $status = null);

    /**
     * Create new courses.
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Delete Course with provided id.
     *
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Update user specified by it's id.
     *
     * @param $id
     * @param array $data
     * @return User
     */
    public function update($id, array $data);
}