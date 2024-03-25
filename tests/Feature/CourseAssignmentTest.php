<?php

use App\Models\Course;
use App\Models\User;
use Spatie\TestTime\TestTime;
use Carbon\Carbon;
use function Pest\Laravel\get;
use function Pest\Laravel\ActingAs;

beforeEach(function () {
    $this->course = Course::factory()->create([
        'name' => 'Introduction to Laravel 11',
        'start_date' => '2024-03-01',
        'end_date' => '2024-03-31'
    ]);
    $this->user = User::factory()->create();
    $this->course->attendants()->attach($this->user, [
        'is_active' => true,
        'enrolled_at' => '2024-02-18 10:00:00',
    ]);
    $this->course->assignments()->create([
        'name' => 'Assignment 1',
        'published_up' => '2024-03-05 10:00:00',
        'published_down' => '2024-03-05 23:59:59'
    ]);

    $this->course->assignments()->create([
        'name' => 'Assignment 2',
        'published_up' => '2024-03-10 10:00:00',
        'published_down' => '2024-03-10 23:59:59'
    ]);

    $this->course->assignments()->create([
        'name' => 'Assignment 3',
        'published_up' => '2024-03-12 10:00:00',
        'published_down' => '2024-03-12 23:59:59'
    ]);
});

it('can only display active and passed assignments for user', function () {

    $freezeTime = Carbon::parse('2024-03-10 12:00:00');
    TestTime::freeze($freezeTime);

    ActingAs($this->user)
        ->get('/course-assignments')
        ->assertSee('Assignments')
        ->assertSee('Assignment 1')
        ->assertSee('Assignment 2' )
        ->assertDontSee('Assignment 3');

});
