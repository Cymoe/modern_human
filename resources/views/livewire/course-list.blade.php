<div class="container mx-auto px-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($courses as $course)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <a href="{{ route('courses.show', $course) }}">
                <img src="{{ $course->image }}" alt="{{ $course->name }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h2 class="text-xl font-semibold mb-2">{{ $course->name }}</h2>
                        <p class="text-gray-600">{{ $course->description }}</p>
                    </div>
                </a>    
            </div>
        @endforeach
    </div>
</div>
