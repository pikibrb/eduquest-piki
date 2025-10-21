<x-app-layout>
    <div class="max-w-4xl mx-auto py-10">
        <h1 class="text-3xl font-bold text-green-600 mb-6">{{ $quiz->title }}</h1>

        <form method="POST" action="{{ route('student.quizzes.submit', $quiz->id) }}">
            @csrf
            @foreach($quiz->questions as $q)
            <div class="border p-4 rounded mb-4 text-white">
                <p class="font-medium">{{ $loop->iteration }}. {{ $q->question_text }}</p>
                @foreach(['a','b','c','d'] as $opt)
                <label class="block mt-1">
                    <input type="radio" name="answers[{{ $q->id }}]" value="{{ $opt }}" required>
                    {{ strtoupper($opt) }}. {{ $q->{'option_'.$opt} }}
                </label>
                @endforeach
            </div>
            @endforeach

            <button type="submit"
                class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                Kumpulkan Jawaban
            </button>
        </form>
    </div>
</x-app-layout>