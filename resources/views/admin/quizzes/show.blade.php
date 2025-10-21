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

                @php
                $options = [
                'A' => $q->option_a ?? null,
                'B' => $q->option_b ?? null,
                'C' => $q->option_c ?? null,
                'D' => $q->option_d ?? null,
                ];

                $raw = $q->correct_option ?? '';

                $normalize = function($val, $opts) {
                $v = trim((string)$val);
                if ($v === '') return '';
                if (preg_match('/^[A-Da-d]$/', $v)) return strtoupper($v);
                if (preg_match('/option[_-]?([A-Da-d])$/i', $v, $m)) return strtoupper($m[1]);
                if (preg_match('/^[1-4]$/', $v)) return ['1'=>'A','2'=>'B','3'=>'C','4'=>'D'][$v] ?? '';
                foreach ($opts as $k => $text) {
                if (is_null($text)) continue;
                if (trim(strip_tags($text)) === trim(strip_tags($v))) return $k;
                if (strcasecmp(trim(strip_tags($text)), trim(strip_tags($v))) === 0) return $k;
                }
                return '';
                };

                $key = $normalize($raw, $options);
                $correctText = $options[$key] ?? $raw ?? '-';
                @endphp

                <p class="mt-2 text-green-600 font-semibold">Jawaban benar: {!! nl2br(e($correctText)) !!}</p>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>