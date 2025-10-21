<x-app-layout>
    <div class="max-w-5xl mx-auto py-10">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-indigo-600">Daftar Kuis</h1>
            <a href="{{ route('admin.quizzes.create') }}"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                + Tambah Kuis
            </a>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-indigo-100">
                    <tr>
                        <th class="px-6 py-3">Judul</th>
                        <th class="px-6 py-3">Jumlah Soal</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quizzes as $quiz)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-6 py-3">{{ $quiz->title }}</td>
                        <td class="px-6 py-3">{{ $quiz->questions_count }}</td>
                        <td class="px-6 py-3 flex gap-2">

                            <a href="{{ route('admin.answers.index', $quiz->id) }}"
                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-lg text-sm">
                                Hasil Kuis
                            </a>
                            <a href="{{ route('admin.quizzes.show', $quiz->id) }}"
                                class="text-blue-600 hover:underline">Lihat</a>

                            <form method="POST" action="{{ route('admin.quizzes.destroy', $quiz->id) }}">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>