<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-6">{{ $course->name }}</h1>
    <div class="flex">
        <!-- Left sidebar with modules and lessons -->
        <div class="w-1/4 pr-4">
            @foreach($this->modules as $module)
                <div x-data="{ open: false }" class="mb-4">
                    <button @click="open = !open" class="flex justify-between items-center w-full bg-gray-200 p-2 rounded">
                        <span>{{ $module->name }}</span>
                        <svg x-show="!open" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        <svg x-show="open" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                    </button>
                    <div x-show="open" class="mt-2 ml-4">
                        @foreach($module->lessons as $lesson)
                            <div class="py-2">
                                <a href="#" wire:click="selectLesson({{ $lesson->id }})" class="text-blue-600 hover:underline">{{ $lesson->name }}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Right side with lesson content -->
        <div class="w-3/4 pl-4">
            @if($selectedLesson)
                <div class="bg-black aspect-video mb-4">
                    <!-- Video player -->
                    <div class="flex items-center justify-center h-full text-white">
                        @if($selectedLesson->video && $selectedLesson->video->loom_url)
                            <iframe width="560" height="315" src="{{ $selectedLesson->video->loom_url }}" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                        @else
                            <p>No video available for this lesson.</p>
                        @endif
                    </div>
                </div>
                <h2 class="text-2xl font-semibold mb-4">{{ $selectedLesson->name }}</h2>
                <div class="prose max-w-none">
                    @if($selectedLesson->video)
                        {!! $selectedLesson->video->description !!}
                    @else
                        <p>{{ $selectedLesson->description }}</p>
                    @endif
                </div>
            @else
                <div class="bg-gray-100 p-4 rounded">
                    <p>Select a lesson to start learning.</p>
                </div>
            @endif
        </div>
    </div>
</div>
