@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-lg p-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-indigo-700">
                Jawaban Siswa: {{ $user->name }}
            </h2>
            <p class="text-gray-600">Kuis: <span class="font-semibold">{{ $quiz->title }}</span></p>
            @if($result)
                <p class="text-gray-700 mt-2">Skor Akhir: 
                    <span class="text-indigo-700 font-bold">{{ $result->score }}%</span>
                </p>
            @endif
        </div>
        <a href="{{ route('admin.answers.index', $quiz->id) }}" 
           class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">
           ← Kembali
        </a>
    </div>

    @foreach ($userAnswers as $index => $answer)
        <div class="p-6 mb-5 rounded-xl border {{ $answer->is_correct ? 'border-green-400 bg-green-50' : 'border-red-400 bg-red-50' }}">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">
                Soal {{ $index + 1 }}:
            </h3>
            <p class="text-gray-700 mb-3">{{ $answer->question->question ?? '-' }}</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                <div class="bg-white rounded-lg p-3 border border-gray-300">
                    <span class="text-gray-600 text-sm">Jawaban Benar:</span>
                    <p class="font-semibold text-green-600">
                        {{ strtoupper($answer->question->correct_option ?? '-') }}
                    </p>
                </div>
                <div class="bg-white rounded-lg p-3 border border-gray-300">
                    <span class="text-gray-600 text-sm">Jawaban Siswa:</span>
                    <p class="font-semibold {{ $answer->is_correct ? 'text-green-600' : 'text-red-600' }}">
                        {{ strtoupper($answer->selected_option ?? '-') }}
                    </p>
                </div>
            </div>

            <div class="mt-3">
                @if($answer->is_correct)
                    <span class="bg-green-100 text-green-800 px-4 py-1 rounded-full text-sm font-medium">
                        ✅ Benar
                    </span>
                @else
                    <span class="bg-red-100 text-red-800 px-4 py-1 rounded-full text-sm font-medium">
                        ❌ Salah
                    </span>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection
