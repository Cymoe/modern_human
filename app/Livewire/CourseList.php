<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;

class CourseList extends Component
{
    public function render()
    {
        return view('livewire.course-list', [
            'courses' => Course::all()
        ]);
    }
}
