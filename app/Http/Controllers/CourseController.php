<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Registration;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::withCount('registrations')->get();
        return view('courses', compact('courses'));
    }

   public function register(Request $request, Course $course)
{
    $validated = $request->validate([
        'name' => 'required|string|max:100',
        'email' => 'required|email',
        'mobile' => 'required|string|max:20',
    ]);

    $alreadyRegistered = $course->registrations()->where('email', $request->email)->exists();

    if ($alreadyRegistered) {
        if ($request->ajax()) {
            return response()->json(['message' => 'You have already registered for this course.'], 422);
        }
        return redirect('/')->with('error', 'You have already registered for this course.');
    }

    $course->registrations()->create($validated);

    if ($request->ajax()) {
        return response()->json(['message' => 'Registration successful!']);
    }

    return redirect('/')->with('success', 'Registration successful!');
}
}
