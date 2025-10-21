<x-app-layout>
    <div class="max-w-5xl mx-auto">
        <h1 class="text-3xl font-bold text-indigo-700 mb-6 text-center">🏆 Leaderboard EduQuest</h1>

        <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
            <table class="w-full border-collapse">
                <thead class="bg-green-100">
                    <tr>
                        <th class="p-3">#</th>
                        <th class="p-3">Nama</th>
                        <th class="p-3">NPM</th>
                        <th class="p-3">Nilai</th>
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
                        <td class="p-3">{{ $entry->user->npm }}</td>
                        <td class="py-3 px-4">{{ $leader->quiz->title }}</td>
                        <td class="py-3 px-4 text-center font-bold text-indigo-700">{{ $leader->score }}</td>
                        <td class="py-3 px-4 text-center text-gray-500">{{ $leader->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-gray-500">Belum ada data leaderboard.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('student.quizzes.index') }}"
                class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-xl font-medium transition">
                Kembali ke Kuis
            </a>
        </div>
    </div>
</x-app-layout>