<x-app-layout>
    <div class="max-w-5xl mx-auto">
        <h1 class="text-3xl font-bold text-indigo-700 mb-4 text-center">🏆 Leaderboard: {{ $quiz->title }}</h1>
        <p class="text-center text-gray-600 mb-8">
            Menampilkan 10 siswa dengan skor tertinggi pada kuis ini.
        </p>

        <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
            <table class="w-full border-collapse">
                <thead class="bg-indigo-600 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left">Peringkat</th>
                        <th class="py-3 px-4 text-left">Nama Siswa</th>
                        <th class="py-3 px-4 text-center">Skor</th>
                        <th class="py-3 px-4 text-center">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($leaders as $index => $leader)
                        @php
                            $rank = $index + 1;
                            $rankColor = match($rank) {
                                1 => 'bg-yellow-100 text-yellow-700 font-bold',
                                2 => 'bg-gray-100 text-gray-700 font-semibold',
                                3 => 'bg-orange-100 text-orange-700 font-semibold',
                                default => 'text-gray-800'
                            };
                        @endphp

                        <tr class="hover:bg-indigo-50 transition">
                            <td class="py-3 px-4 {{ $rankColor }}">
                                @if($rank == 1)
                                    🥇
                                @elseif($rank == 2)
                                    🥈
                                @elseif($rank == 3)
                                    🥉
                                @else
                                    {{ $rank }}
                                @endif
                            </td>
                            <td class="py-3 px-4 font-semibold">{{ $leader->user->name }}</td>
                            <td class="py-3 px-4 text-center font-bold text-indigo-700">{{ $leader->score }}</td>
                            <td class="py-3 px-4 text-center text-gray-500">{{ $leader->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-6 text-center text-gray-500">Belum ada siswa yang mengerjakan kuis ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('student.quizzes.index') }}"
               class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-xl font-medium transition">
                🔙 Kembali ke Daftar Kuis
            </a>
        </div>
    </div>
</x-app-layout>
