<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Registration;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run():void
{
    $courses = [
        ['title' => 'Laravel Bootcamp', 'course_date' => now()->addDays(10), 'base_price' => 100],
        ['title' => 'Vue.js Mastery', 'course_date' => now()->addDays(20), 'base_price' => 120],
    ];

    foreach ($courses as $courseData) {
        $course = Course::create($courseData);

        // Create 0 to 6 registrations randomly
        $count = rand(0, 6);
        Registration::factory()->count($count)->create([
            'course_id' => $course->id
        ]);
    }
}
}
