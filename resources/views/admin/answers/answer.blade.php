@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Siswa - {{ $quiz->title }}</h2>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Nama Siswa</th>
                <th>Skor</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                <tr>
                    <td>{{ $student['user']->name }}</td>
                    <td>{{ $student['score'] }}%</td>
                    <td>
                        <a href="{{ route('admin.answers.show', [$quiz->id, $student['user']->id]) }}" class="btn btn-info btn-sm">
                            Lihat Jawaban
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
