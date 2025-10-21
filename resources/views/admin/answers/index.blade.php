@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-lg p-8">
    <h2 class="text-2xl font-bold text-indigo-700 mb-6">
        Daftar Siswa Kuis: {{ $quiz->title }}
    </h2>

    <table class="min-w-full text-left border border-gray-200 rounded-lg overflow-hidden">
        <thead class="bg-indigo-100 text-indigo-800">
            <tr>
                <th class="px-4 py-2">No</th>
                <th class="px-4 py-2">Nama Siswa</th>
                <th class="px-4 py-2">Skor</th>
                <th class="px-4 py-2 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($answers as $index => $answer)
            <tr class="border-t hover:bg-indigo-50">
                <td class="px-4 py-2">{{ $index + 1 }}</td>
                <td class="px-4 py-2 font-medium">{{ $answer->user->name }}</td>
                <td class="px-4 py-2 font-semibold text-indigo-700">{{ $answer->score }}%</td>
                <td class="px-4 py-2 text-center">
                    <a href="{{ route('admin.answers.show', [$quiz->id, $answer->user->id]) }}"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">
                        Lihat Jawaban
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center text-gray-500 py-4">
                    Belum ada siswa yang menyelesaikan kuis ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection