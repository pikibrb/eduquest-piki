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

        @php
        $q = $answer->question;

        $getAttr = function($obj, $names) {
        foreach ($names as $n) {
        if (is_object($obj) && isset($obj->{$n}) && $obj->{$n} !== null && $obj->{$n} !== '') {
        return $obj->{$n};
        }
        }
        return null;
        };

        $questionText = $getAttr($q, ['question','text','content','body'])
        ?? ($answer->question_text ?? $answer->question_body ?? '-');
        $questionImage = $getAttr($q, ['image','img','image_path']) ?? ($answer->question_image ?? null);
        @endphp

        <div class="mb-3">
            <p class="text-gray-700">{!! nl2br(e($questionText)) !!}</p>

            @if(!empty($questionImage))
            <div class="mt-3">
                <img src="{{ asset('storage/' . $questionImage) }}" alt="soal-image" class="rounded max-h-60 object-contain">
            </div>
            @endif
        </div>

        @php
        $getOptionValue = function($qObj, $ansObj, $names) {
        foreach ($names as $n) {
        if (is_object($qObj) && isset($qObj->{$n}) && $qObj->{$n} !== null && $qObj->{$n} !== '') {
        return $qObj->{$n};
        }
        if (isset($ansObj->{$n}) && $ansObj->{$n} !== null && $ansObj->{$n} !== '') {
        return $ansObj->{$n};
        }
        }
        return null;
        };

        $options = [
        'A' => $getOptionValue($q, $answer, ['option_a','a','option1','option_1','choice_a','answer_a']),
        'B' => $getOptionValue($q, $answer, ['option_b','b','option2','option_2','choice_b','answer_b']),
        'C' => $getOptionValue($q, $answer, ['option_c','c','option3','option_3','choice_c','answer_c']),
        'D' => $getOptionValue($q, $answer, ['option_d','d','option4','option_4','choice_d','answer_d']),
        ];

        $rawCorrect = $getAttr($q, ['correct_option','correct','answer_key','answer']) ?? ($answer->correct_option ?? $answer->correct ?? '');
        $rawSelected = $answer->selected_option ?? $answer->selected ?? $answer->answer ?? '';

        $normalize = function($val, $opts) {
        $v = trim((string)$val);
        if ($v === '') return '';
        if (preg_match('/^[A-Da-d]$/', $v)) return strtoupper($v);
        if (preg_match('/option[_-]?([A-Da-d])$/i', $v, $m)) return strtoupper($m[1]);
        if (preg_match('/^[1-4]$/', $v)) {
        return ['1'=>'A','2'=>'B','3'=>'C','4'=>'D'][$v] ?? '';
        }
        foreach ($opts as $k => $text) {
        if (is_null($text)) continue;
        $plainText = trim(strip_tags($text));
        $plainVal = trim(strip_tags($v));
        if ($plainText === $plainVal) return $k;
        if (strcasecmp($plainText, $plainVal) === 0) return $k;
        }
        return strtoupper(substr($v, 0, 1));
        };

        $correct = $normalize($rawCorrect, $options);
        $selected = $normalize($rawSelected, $options);
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
            @foreach($options as $key => $text)
            @if($text)
            @php
            $isCorrect = ($key === $correct);
            $isSelected = ($key === $selected);
            $baseBorder = $isCorrect ? 'border-green-500 bg-green-50' : ($isSelected ? 'border-red-500 bg-red-50' : 'border-gray-300 bg-white');
            @endphp

            <div class="p-3 rounded-lg border {{ $baseBorder }}">
                <div class="flex items-start gap-3">
                    <span class="font-bold w-6 text-center {{ $isCorrect ? 'text-green-700' : ($isSelected ? 'text-red-700' : 'text-gray-700') }}">{{ $key }}</span>
                    <div class="text-sm text-gray-800">
                        {!! nl2br(e($text)) !!}
                    </div>
                </div>
            </div>
            @endif
            @endforeach
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