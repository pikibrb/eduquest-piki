<x-app-layout>
    <div class="max-w-4xl mx-auto py-10">
        <h1 class="text-3xl font-bold text-green-600 mb-6">Pilih Kuis</h1>

        <div class="grid gap-4">
            @foreach($quizzes as $quiz)
            <div class="border p-4 rounded-lg bg-white shadow hover:shadow-lg transition flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-semibold">{{ $quiz->title }}</h2>
                    <p class="text-gray-600">{{ $quiz->description }}</p>
                </div>

                <div class="flex items-center gap-3">
                    @if(in_array($quiz->id, $doneQuizIds))
                    <a href="{{ route('student.quizzes.result', $quiz->id) }}"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-lg">
                        Lihat Hasil
                    </a>
                    <span class="ml-2 inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">Sudah dikerjakan</span>
                    @else
                    <a href="{{ route('student.quizzes.start', $quiz->id) }}"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg">
                        Mulai Kuis
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>