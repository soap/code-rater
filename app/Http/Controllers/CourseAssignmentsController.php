<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseAssignmentsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('course-assignments.index');
    }
}
