<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseAssignment;

class AssignmentSubmissionsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CourseAssignment $assignment)
    {
        return view('assignment-submissions.index', compact('assignment'));
    }
}
