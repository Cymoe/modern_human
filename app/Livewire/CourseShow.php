<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Lesson;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]  // Assuming you have a layout at resources/views/layouts/app.blade.php
class CourseShow extends Component
{
    public Course $course;
    public $modules;
    public $selectedLesson = null;

    public function mount(Course $course)
    {
        $this->course = $course;
        $this->modules = $course->modules()->with('lessons')->get();
    }

    public function selectLesson($lessonId)
    {
        $this->selectedLesson = Lesson::with('video')->find($lessonId);
    }

    public function render()
    {
        return view('livewire.course-show');
    }
}
