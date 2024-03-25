<?php

use App\Models\Course;
use App\Models\User;

it('can attend course', function () {
    $course = Course::factory()->create();
    $user = User::factory()->create();
    $course->attendants()->attach($user->id);
    $this->assertDatabaseHas('course_attendants', [
        'course_id' => $course->id,
        'user_id' => $user->id,
    ]);
});
