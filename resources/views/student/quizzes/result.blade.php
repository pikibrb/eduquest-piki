@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto text-center py-10">
    <div class="bg-white rounded-2xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-green-600 mb-2">🎉 Hasil Kuis</h1>
        <p class="text-lg text-gray-700 mb-4">{{ $quiz->title }}</p>

        <div class="text-2xl font-semibold text-indigo-700 mb-6">
            Nilai Kamu: <span class="text-4xl">{{ $result->score }}%</span>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('leaderboard.quiz', $quiz->id) }}"
                class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-xl font-medium transition">
                🏆 Lihat Leaderboard Kuis Ini
            </a>
        </div><br>
        <a href="{{ route('student.quizzes.index') }}"
            class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
            Kembali ke Daftar Kuis
        </a>
    </div>

    @if(isset($userAnswers) && $userAnswers->count())
    <div class="mt-8 bg-white rounded-2xl shadow-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Detail Jawaban</h2>

        @foreach($userAnswers as $idx => $ua)
        <div class="p-4 mb-3 rounded-lg border {{ $ua->is_correct ? 'border-green-300 bg-green-50' : 'border-red-300 bg-red-50' }}">
            <p class="font-medium">{{ $idx + 1 }}. {{ $ua->question->question_text ?? $ua->question->question ?? '—' }}</p>
            <div class="flex gap-4 mt-2">
                <div>
                    <span class="text-sm text-gray-600">Jawaban Kamu</span>
                    <div class="font-semibold {{ $ua->is_correct ? 'text-green-700' : 'text-red-700' }}">
                        {{ strtoupper($ua->selected_option ?? '-') }}
                    </div>
                </div>

                <div>
                    <span class="text-sm text-gray-600">Jawaban Benar</span>
                    <div class="font-semibold text-green-700">
                        {{ strtoupper($ua->question->correct_option ?? '-') }}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection