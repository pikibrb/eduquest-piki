<x-app-layout>
    <div class="max-w-4xl mx-auto py-10">
        <h1 class="text-3xl font-bold text-indigo-600 mb-6">{{ $quiz->title }}</h1>
        <p class="mb-4 text-gray-600">{{ $quiz->description }}</p>

        <h2 class="text-xl font-semibold mb-4 text-white">Daftar Soal</h2>
        <div class="space-y-4">
            @foreach($quiz->questions as $q)
                <div class="border p-4 rounded-lg text-white">
                    <p class="font-medium">{{ $loop->iteration }}. {{ $q->question_text }}</p>
                    <ul class="ml-5 mt-2 list-disc">
                        <li>A. {{ $q->option_a }}</li>
                        <li>B. {{ $q->option_b }}</li>
                        <li>C. {{ $q->option_c }}</li>
                        <li>D. {{ $q->option_d }}</li>
                    </ul>
                    <p class="mt-2 text-green-600 font-semibold">Jawaban benar: {{ strtoupper($q->correct_option) }}</p>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
