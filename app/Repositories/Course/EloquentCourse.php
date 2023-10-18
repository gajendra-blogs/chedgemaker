<?php

namespace Vanguard\Repositories\Course;
use Vanguard\Models\Course;
use Vanguard\Events\Course\Created;
use Vanguard\Http\Filters\CourseKeywordSearch;
use Illuminate\Support\Facades\Crypt;
class EloquentCourse implements CourseRepository
{
      /**
     * {@inheritdoc}
     */
    public function all()
    {
        return Course::all();
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        return Course::create($data);
    }

     /**
     * {@inheritdoc}
     */
    public function paginate($perPage, $search = null, $status = null , $request = null)
    {
        $query = Course::query();

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            (new CourseKeywordSearch)($query, $search);
        }

        if($request->column && $request->order){
            $column = Crypt::decrypt($request->column);
            $result = $query->orderBy($column, $request->order)
            ->paginate($perPage);
        }
        else
        {
            $result = $query->orderBy('course_name', 'asc')
            ->paginate($perPage);
        }
        // dd($result);

        if ($search) {
            $result->appends(['search' => $search]);
        }
        if ($status) {
            $result->appends(['status' => $status]);
        }

        return $result;
    }


    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $course = $this->find($id);
        return $course->delete();
    }

       /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Course::find($id);
    }


    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        $course = $this->find($id);

        $course->update($data);

        return $course;
    }
}